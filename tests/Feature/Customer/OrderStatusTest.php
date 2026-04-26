<?php

use App\Models\Order;
use App\Models\User;

it('shows on_rent orders in the renting tab and profile summary', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    Order::create([
        'user_id' => $user->id,
        'loan_date' => now()->subDay(),
        'return_date' => now()->addDays(2),
        'duration' => 3,
        'status' => 'on_rent',
        'total_price' => 150000,
        'total_fine' => 0,
    ]);

    $profileResponse = $this->actingAs($user)->get(route('profile.index'));

    $profileResponse
        ->assertOk()
        ->assertViewHas('rentingCount', 1);

    $rentingResponse = $this->actingAs($user)->get(route('profile.orders.renting'));

    $rentingResponse
        ->assertOk()
        ->assertViewHas('orders', fn ($orders) => $orders->count() === 1 && $orders->first()->status === 'on_rent');
});

it('shows the failed payment page for cancelled orders', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $order = Order::create([
        'user_id' => $user->id,
        'loan_date' => now(),
        'return_date' => now()->addDay(),
        'duration' => 1,
        'status' => 'cancelled',
        'total_price' => 120000,
        'total_fine' => 0,
    ]);

    $response = $this->actingAs($user)->get(route('payment.status', $order));

    $response
        ->assertOk()
        ->assertViewIs('customer.payment-failed');
});
