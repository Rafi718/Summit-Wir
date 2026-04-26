<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pendingCount = Order::where('user_id', $user->id)->where('status', Order::STATUS_PENDING)->count();
        $rentingCount = Order::where('user_id', $user->id)->where('status', Order::STATUS_ON_RENT)->count();
        $completedCount = Order::where('user_id', $user->id)->where('status', Order::STATUS_COMPLETED)->count();
        $cancelledCount = Order::where('user_id', $user->id)->where('status', Order::STATUS_CANCELLED)->count();

        return view(
            'customer.profile.index',
            compact('user', 'pendingCount', 'rentingCount', 'completedCount', 'cancelledCount'),
        );
    }

    public function edit()
    {
        $user = Auth::user();

        return view('customer.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'ktp_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['current_password']) && !empty($validated['password'])) {
            if (password_verify($validated['current_password'], $user->password)) {
                $user->password = bcrypt($validated['password']);
            } else {
                return back()
                    ->withErrors(['current_password' => 'Password lama tidak sesuai.'])
                    ->withInput();
            }
        }

        if ($request->hasFile('ktp_image')) {
            $extension = $request->file('ktp_image')->getClientOriginalExtension();
            $filename = $user->id . '.' . $extension;

            if ($user->ktp_image && Storage::disk('public')->exists($user->ktp_image)) {
                Storage::disk('public')->delete($user->ktp_image);
            }

            $path = $request->file('ktp_image')->storeAs('ktp', $filename, 'public');
            $user->ktp_image = $path;
        }

        $user->name = $validated['name'];
        $user->no_hp = $validated['no_hp'] ?? $user->no_hp;
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function pendingOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('status', Order::STATUS_PENDING)
            ->with(['orderDetails.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.orders.pending', compact('orders'));
    }

    public function rentingOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('status', Order::STATUS_ON_RENT)
            ->with(['orderDetails.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.orders.renting', compact('orders'));
    }

    public function returnOrder(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        if ($order->status !== Order::STATUS_ON_RENT) {
            return back()->with('error', 'Order ini belum berada dalam status sedang disewa.');
        }

        $order->releaseStock();
        $order->completeRental();

        return redirect()
            ->route('profile.orders.completed')
            ->with('success', 'Pengembalian barang berhasil dikonfirmasi.');
    }

    public function completedOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('status', Order::STATUS_COMPLETED)
            ->with(['orderDetails.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.orders.completed', compact('orders'));
    }

    public function cancelledOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('status', Order::STATUS_CANCELLED)
            ->with(['orderDetails.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.orders.cancelled', compact('orders'));
    }
}
