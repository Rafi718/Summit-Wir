<?php

namespace App\Services;

use App\Models\Order;

class OrderReceiptWhatsappService
{
    public function __construct(private readonly FonnteService $fonnteService)
    {
    }

    public function send(Order $order): bool
    {
        if ($order->whatsapp_receipt_sent_at || $order->whatsapp_receipt_send_attempted_at) {
            return false;
        }

        $order->loadMissing(['user', 'orderDetails.product']);

        if (blank($order->user?->no_hp)) {
            return false;
        }

        if (blank(config('services.fonnte.token'))) {
            return false;
        }

        $attemptReserved = Order::whereKey($order->id)
            ->whereNull('whatsapp_receipt_sent_at')
            ->whereNull('whatsapp_receipt_send_attempted_at')
            ->update([
                'whatsapp_receipt_send_attempted_at' => now(),
            ]);

        if ($attemptReserved === 0) {
            return false;
        }

        $sent = $this->fonnteService->sendMessage(
            $order->user->no_hp,
            $this->buildMessage($order),
        );

        if ($sent) {
            $order->forceFill([
                'whatsapp_receipt_sent_at' => now(),
            ])->save();
        }

        return $sent;
    }

    private function buildMessage(Order $order): string
    {
        $orderNumber = 'ORD'.str_pad((string) $order->id, 5, '0', STR_PAD_LEFT);
        $downPayment = (int) round($order->total_price * 0.5);
        $remainingPayment = max((int) $order->total_price - $downPayment, 0);
        $items = $order->orderDetails
            ->map(fn ($detail) => "- {$detail->product->name} x{$detail->quantity}")
            ->implode("\n");

        return implode("\n", [
            "Halo {$order->user->name}, pembayaran DP Summit Wir berhasil.",
            '',
            "No Pesanan: {$orderNumber}",
            'Status: Sedang Disewa',
            'Total Sewa: Rp'.number_format((int) $order->total_price, 0, ',', '.'),
            'DP Dibayar: Rp'.number_format($downPayment, 0, ',', '.'),
            'Sisa Bayar: Rp'.number_format($remainingPayment, 0, ',', '.'),
            "Durasi: {$order->duration} hari",
            'Tanggal Ambil: '.$order->loan_date?->format('d M Y'),
            'Tanggal Kembali: '.$order->return_date?->format('d M Y'),
            '',
            "Barang:\n{$items}",
            '',
            'Lihat struk:',
            route('profile.orders.invoice', $order),
        ]);
    }
}
