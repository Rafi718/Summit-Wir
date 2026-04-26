<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Midtrans\Transaction;

class MidtransTransactionStatusService
{
    public function getStatus(Order $order): ?string
    {
        try {
            $status = Transaction::status((string) $order->id);

            return data_get($status, 'transaction_status');
        } catch (\Throwable $exception) {
            Log::warning('Failed to verify Midtrans transaction status.', [
                'order_id' => $order->id,
                'error' => $exception->getMessage(),
            ]);

            return null;
        }
    }
}
