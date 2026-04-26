<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $orders = Order::with('user')
            ->when($request->filled('status'), function ($query) use ($request) {
                if ($request->status === Order::STATUS_OVERDUE) {
                    $query
                        ->whereNotIn('status', [Order::STATUS_COMPLETED, Order::STATUS_CANCELLED])
                        ->whereRaw('DATE_ADD(loan_date, INTERVAL duration DAY) < ?', [now()]);
                } else {
                    $query->where('status', $request->status);
                }
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    /**
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderDetails']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * @return \Illuminate\View\View
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,paid,on_rent,overdue,completed,cancelled,failed,expired',
        ]);

        $previousStatus = Order::canonicalizeStatus($order->status);
        $nextStatus = Order::canonicalizeStatus($validated['status']);
        $stockWasReserved = $order->hasReservedStock();

        if ($nextStatus === Order::STATUS_PAID) {
            if (!$stockWasReserved) {
                $order->reserveStock();
            }

            $order->update(['status' => Order::STATUS_PAID]);

            return redirect()
                ->route('admin.orders.show', $order->id)
                ->with('success', 'Status order berhasil diperbarui.');
        }

        if ($nextStatus === Order::STATUS_ON_RENT) {
            if (!$stockWasReserved) {
                $order->reserveStock();
            }

            $order->startRental();

            return redirect()
                ->route('admin.orders.show', $order->id)
                ->with('success', 'Status order berhasil diperbarui.');
        }

        if ($nextStatus === Order::STATUS_COMPLETED) {
            if ($stockWasReserved) {
                $order->releaseStock();
            }

            $order->completeRental();

            return redirect()
                ->route('admin.orders.show', $order->id)
                ->with('success', 'Status order berhasil diperbarui.');
        }

        if (
            in_array($nextStatus, [Order::STATUS_CANCELLED, Order::STATUS_FAILED, Order::STATUS_EXPIRED], true)
            && $stockWasReserved
            && $previousStatus !== $nextStatus
        ) {
            $order->releaseStock();
        }

        $order->update(['status' => $nextStatus]);

        return redirect()
            ->route('admin.orders.show', $order->id)
            ->with('success', 'Status order berhasil diperbarui.');
    }
}
