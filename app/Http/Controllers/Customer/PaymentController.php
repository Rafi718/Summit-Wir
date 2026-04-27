<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\MidtransTransactionStatusService;
use App\Services\OrderReceiptWhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct(
        private readonly OrderReceiptWhatsappService $orderReceiptWhatsappService,
        private readonly MidtransTransactionStatusService $midtransTransactionStatusService,
    ) {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = false;
    }

    /**
     * Show payment page & generate QRIS Snap token
     */
    public function pay(Order $order)
    {
        $user = Auth::user();

        if ($order->user_id != $user->id) {
            abort(403);
        }

        // If order already has a snap token, reuse it
        if ($order->snap_token && $order->status === 'pending') {
            return view('customer.payment', [
                'order' => $order,
                'snapToken' => $order->snap_token,
            ]);
        }

        $orderId = $order->id;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) round($order->total_price * 0.5),
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'callbacks' => [
                'finish' => route('profile.orders.invoice', $order),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Throwable $exception) {
            Log::error('Failed to create Midtrans Snap token.', [
                'order_id' => $order->id,
                'amount' => $params['transaction_details']['gross_amount'],
                'is_production' => config('midtrans.is_production'),
                'has_server_key' => filled(config('midtrans.server_key')),
                'finish_url' => $params['callbacks']['finish'],
                'error' => $exception->getMessage(),
            ]);

            return redirect()
                ->route('checkout', $order)
                ->with('error', 'Pembayaran belum dapat diproses. Silakan coba lagi beberapa saat.');
        }

        $order->update(['snap_token' => $snapToken]);

        return view('customer.payment', compact('order', 'snapToken'));
    }

    /**
     * Handle Midtrans QRIS payment notification (Webhook)
     */
    public function notificationHandler(Request $request)
    {
        try {
            Log::info('Midtrans QRIS Notification Received:', $request->all());
            $data = $request->all();

            if (!isset($data['order_id'])) {
                return response()->json(['message' => 'Invalid notification data'], 400);
            }

            // Extract the base order ID (before the dash)
            $orderId = $data['order_id'];

            $order = Order::find($orderId);
            if (!$order) {
                Log::warning('Order not found', ['order_id' => $orderId]);
                return response()->json(['message' => 'Order not found'], 404);
            }

            $this->applyTransactionStatus($order, $data['transaction_status']);

            return response()->json(['message' => 'Notification processed']);
        } catch (\Exception $e) {
            Log::error('Midtrans QRIS Notification Error:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function sync(Request $request, Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'transaction_status' => 'required|string',
        ]);

        $verifiedTransactionStatus = $this->midtransTransactionStatusService->getStatus($order);

        if ($verifiedTransactionStatus) {
            $this->applyTransactionStatus($order, $verifiedTransactionStatus);
        }

        return response()->json([
            'message' => 'Payment status synced',
            'status' => $order->fresh()->status,
            'redirect_url' => route('profile.orders.invoice', $order, false),
        ]);
    }

    /**
     * Redirect after payment
     */
    public function status(Order $order)
    {
        $user = Auth::user();
        if ($order->user_id != $user->id) {
            abort(403, 'Unauthorized access');
        }

        switch ($order->status) {
            case Order::STATUS_PAID:
            case Order::STATUS_ON_RENT:
                $order->load('orderDetails.product');
                return view('customer.payment-success', compact('order'));
            case Order::STATUS_PENDING:
                return view('customer.payment-pending', compact('order'));
            case Order::STATUS_FAILED:
            case Order::STATUS_EXPIRED:
            case Order::STATUS_CANCELLED:
                return view('customer.payment-failed', compact('order'));
            default:
                return redirect()->route('profile.index')->with('error', 'Status pembayaran tidak diketahui.');
        }
    }

    private function applyTransactionStatus(Order $order, string $transactionStatus, bool $sendReceipt = true): void
    {
        $stockWasReserved = $order->hasReservedStock();

        switch ($transactionStatus) {
            case 'pending':
                if (!$stockWasReserved) {
                    $order->update(['status' => Order::STATUS_PENDING]);
                }

                break;

            case 'capture':
            case 'settlement':
                if (!$stockWasReserved) {
                    $order->reserveStock();
                }

                $order->startRental();
                if ($sendReceipt) {
                    $this->orderReceiptWhatsappService->send($order->fresh());
                }
                break;

            case 'expire':
                if ($stockWasReserved) {
                    $order->releaseStock();
                }

                $order->update(['status' => Order::STATUS_EXPIRED]);
                break;

            case 'cancel':
                if ($stockWasReserved) {
                    $order->releaseStock();
                }

                $order->update(['status' => Order::STATUS_CANCELLED]);
                break;

            case 'deny':
                if ($stockWasReserved) {
                    $order->releaseStock();
                }

                $order->update(['status' => Order::STATUS_FAILED]);
                break;

            default:
                Log::warning("Unhandled Midtrans status: {$transactionStatus}");
                break;
        }
    }
}
