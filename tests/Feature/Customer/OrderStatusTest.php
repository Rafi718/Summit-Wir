<?php

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Services\MidtransTransactionStatusService;
use App\Models\User;
use Illuminate\Support\Facades\Http;

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

it('lets customers confirm returning their active rental and restores stock', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $product = Product::create([
        'name' => 'Tenda Dome',
        'description' => 'Tenda camping 4 orang',
        'price' => 50000,
        'stock' => 3,
        'sold' => 1,
        'image' => 'products/tents.jpg',
    ]);

    $order = Order::create([
        'user_id' => $user->id,
        'loan_date' => now()->subDays(2),
        'return_date' => now()->addDay(),
        'duration' => 3,
        'status' => Order::STATUS_ON_RENT,
        'total_price' => 150000,
        'total_fine' => 0,
    ]);

    OrderDetail::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => 2,
    ]);

    $response = $this->actingAs($user)->put(route('profile.orders.return', $order));

    $response
        ->assertRedirect(route('profile.orders.completed'))
        ->assertSessionHas('success');

    expect($order->fresh()->status)->toBe(Order::STATUS_COMPLETED)
        ->and($product->fresh()->stock)->toBe(5);
});

it('does not let customers return another user order', function () {
    $owner = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    $otherUser = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $order = Order::create([
        'user_id' => $owner->id,
        'loan_date' => now()->subDay(),
        'return_date' => now()->addDay(),
        'duration' => 2,
        'status' => Order::STATUS_ON_RENT,
        'total_price' => 100000,
        'total_fine' => 0,
    ]);

    $this->actingAs($otherUser)
        ->put(route('profile.orders.return', $order))
        ->assertForbidden();
});

it('shows rental duration options up to fourteen days on product detail', function () {
    $product = Product::create([
        'name' => 'Carrier 60L',
        'description' => 'Tas gunung',
        'price' => 40000,
        'stock' => 4,
        'sold' => 0,
        'image' => 'products/backpacks.jpg',
    ]);

    $response = $this->get(route('product.detail', $product));

    $response
        ->assertOk()
        ->assertSee('14 Hari', false);
});

it('does not reserve stock twice when payment settlement is received more than once', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $product = Product::create([
        'name' => 'Headlamp',
        'description' => 'Lampu kepala',
        'price' => 20000,
        'stock' => 10,
        'sold' => 0,
        'image' => 'products/lighting.jpg',
    ]);

    $order = Order::create([
        'user_id' => $user->id,
        'duration' => 2,
        'status' => Order::STATUS_PENDING,
        'total_price' => 40000,
        'total_fine' => 0,
    ]);

    OrderDetail::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => 2,
    ]);

    $payload = [
        'order_id' => $order->id,
        'transaction_status' => 'settlement',
    ];

    $this->postJson('/payment/notification', $payload)->assertOk();
    $this->postJson('/payment/notification', $payload)->assertOk();

    $order->refresh();

    expect($order->status)->toBe(Order::STATUS_ON_RENT)
        ->and($order->loan_date)->not->toBeNull()
        ->and($order->return_date)->not->toBeNull()
        ->and($product->fresh()->stock)->toBe(8)
        ->and($product->fresh()->sold)->toBe(2);
});

it('sends a whatsapp receipt once when payment settlement succeeds', function () {
    config(['services.fonnte.token' => 'test-token']);

    Http::fake([
        'api.fonnte.com/send' => Http::response([
            'status' => true,
            'detail' => 'success! message in queue',
        ]),
    ]);

    $user = User::factory()->create([
        'email_verified_at' => now(),
        'name' => 'Budi Summit',
        'no_hp' => '081234567890',
    ]);

    $product = Product::create([
        'name' => 'Tenda Family',
        'description' => 'Tenda camping keluarga',
        'price' => 100000,
        'stock' => 4,
        'sold' => 0,
        'image' => 'products/tents.jpg',
    ]);

    $order = Order::create([
        'user_id' => $user->id,
        'duration' => 2,
        'status' => Order::STATUS_PENDING,
        'total_price' => 200000,
        'total_fine' => 0,
    ]);

    OrderDetail::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => 1,
    ]);

    $payload = [
        'order_id' => $order->id,
        'transaction_status' => 'settlement',
    ];

    $this->postJson('/payment/notification', $payload)->assertOk();
    $this->postJson('/payment/notification', $payload)->assertOk();

    $order->refresh();

    expect($order->whatsapp_receipt_sent_at)->not->toBeNull();

    Http::assertSentCount(1);
    Http::assertSent(fn ($request) => $request->url() === 'https://api.fonnte.com/send'
        && $request['target'] === '081234567890'
        && str_contains($request['message'], 'Budi Summit')
        && str_contains($request['message'], 'ORD'.str_pad((string) $order->id, 5, '0', STR_PAD_LEFT))
        && str_contains($request['message'], 'Rp100.000')
        && str_contains($request['message'], route('profile.orders.invoice', $order))
        && $request['countryCode'] === '62');
});

it('does not retry whatsapp receipts automatically after a fonnte failure', function () {
    config(['services.fonnte.token' => 'test-token']);

    Http::fake([
        'api.fonnte.com/send' => Http::response([
            'status' => false,
            'reason' => 'server error',
        ], 500),
    ]);

    $user = User::factory()->create([
        'email_verified_at' => now(),
        'name' => 'Aman Summit',
        'no_hp' => '081234567891',
    ]);

    $product = Product::create([
        'name' => 'Sleeping Bag',
        'description' => 'Sleeping bag hangat',
        'price' => 50000,
        'stock' => 3,
        'sold' => 0,
        'image' => 'products/sleeping-bag.jpg',
    ]);

    $order = Order::create([
        'user_id' => $user->id,
        'duration' => 1,
        'status' => Order::STATUS_PENDING,
        'total_price' => 50000,
        'total_fine' => 0,
    ]);

    OrderDetail::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => 1,
    ]);

    $payload = [
        'order_id' => $order->id,
        'transaction_status' => 'settlement',
    ];

    $this->postJson('/payment/notification', $payload)->assertOk();
    $this->postJson('/payment/notification', $payload)->assertOk();

    $order->refresh();

    expect($order->whatsapp_receipt_send_attempted_at)->not->toBeNull();
    expect($order->whatsapp_receipt_sent_at)->toBeNull();

    Http::assertSentCount(1);
});

it('does not trust browser payment sync status when midtrans has not confirmed settlement', function () {
    config(['services.fonnte.token' => 'test-token']);

    $this->app->bind(MidtransTransactionStatusService::class, fn () => new class extends MidtransTransactionStatusService
    {
        public function getStatus(Order $order): ?string
        {
            return 'pending';
        }
    });

    Http::fake([
        'api.fonnte.com/send' => Http::response([
            'status' => true,
            'detail' => 'success! message in queue',
        ]),
    ]);

    $user = User::factory()->create([
        'email_verified_at' => now(),
        'no_hp' => '081234567892',
    ]);

    $product = Product::create([
        'name' => 'Carrier 45L',
        'description' => 'Tas carrier',
        'price' => 80000,
        'stock' => 5,
        'sold' => 0,
        'image' => 'products/carrier.jpg',
    ]);

    $order = Order::create([
        'user_id' => $user->id,
        'duration' => 1,
        'status' => Order::STATUS_PENDING,
        'total_price' => 80000,
        'total_fine' => 0,
    ]);

    OrderDetail::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => 1,
    ]);

    $this->actingAs($user)->postJson(route('payment.sync', $order), [
        'transaction_status' => 'settlement',
    ])->assertOk();

    $order->refresh();

    expect($order->status)->toBe(Order::STATUS_PENDING);
    expect($order->whatsapp_receipt_send_attempted_at)->toBeNull();
    expect($order->whatsapp_receipt_sent_at)->toBeNull();

    Http::assertNothingSent();
});

it('sends whatsapp receipts from browser payment sync after midtrans confirms settlement', function () {
    config(['services.fonnte.token' => 'test-token']);

    $this->app->bind(MidtransTransactionStatusService::class, fn () => new class extends MidtransTransactionStatusService
    {
        public function getStatus(Order $order): ?string
        {
            return 'settlement';
        }
    });

    Http::fake([
        'api.fonnte.com/send' => Http::response([
            'status' => true,
            'detail' => 'success! message in queue',
        ]),
    ]);

    $user = User::factory()->create([
        'email_verified_at' => now(),
        'name' => 'Sync Summit',
        'no_hp' => '085774912005',
    ]);

    $product = Product::create([
        'name' => 'Flysheet',
        'description' => 'Pelindung hujan',
        'price' => 30000,
        'stock' => 5,
        'sold' => 0,
        'image' => 'products/flysheet.jpg',
    ]);

    $order = Order::create([
        'user_id' => $user->id,
        'duration' => 1,
        'status' => Order::STATUS_PENDING,
        'total_price' => 30000,
        'total_fine' => 0,
    ]);

    OrderDetail::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => 1,
    ]);

    $this->actingAs($user)->postJson(route('payment.sync', $order), [
        'transaction_status' => 'settlement',
    ])->assertOk();

    $order->refresh();

    expect($order->status)->toBe(Order::STATUS_ON_RENT);
    expect($order->whatsapp_receipt_send_attempted_at)->not->toBeNull();
    expect($order->whatsapp_receipt_sent_at)->not->toBeNull();

    Http::assertSentCount(1);
});

it('does not reserve stock again when admin starts a paid rental', function () {
    $admin = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'admin',
    ]);
    $customer = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $product = Product::create([
        'name' => 'Kompor Portable',
        'description' => 'Kompor camping',
        'price' => 30000,
        'stock' => 6,
        'sold' => 0,
        'image' => 'products/cooking-gear.jpg',
    ]);

    $order = Order::create([
        'user_id' => $customer->id,
        'duration' => 3,
        'status' => Order::STATUS_PENDING,
        'total_price' => 90000,
        'total_fine' => 0,
    ]);

    OrderDetail::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => 1,
    ]);

    $this->actingAs($admin)
        ->put(route('admin.orders.update', $order), ['status' => Order::STATUS_PAID])
        ->assertRedirect(route('admin.orders.show', $order));

    $this->actingAs($admin)
        ->put(route('admin.orders.update', $order), ['status' => Order::STATUS_ON_RENT])
        ->assertRedirect(route('admin.orders.show', $order));

    $order->refresh();

    expect($order->status)->toBe(Order::STATUS_ON_RENT)
        ->and($order->loan_date)->not->toBeNull()
        ->and($order->return_date)->not->toBeNull()
        ->and($product->fresh()->stock)->toBe(5)
        ->and($product->fresh()->sold)->toBe(1);
});

it('starts the rental from snap success callback and shows it in the renting tab', function () {
    $this->app->bind(MidtransTransactionStatusService::class, fn () => new class extends MidtransTransactionStatusService
    {
        public function getStatus(Order $order): ?string
        {
            return 'settlement';
        }
    });

    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $product = Product::create([
        'name' => 'Matras Camping',
        'description' => 'Matras lipat',
        'price' => 25000,
        'stock' => 7,
        'sold' => 0,
        'image' => 'products/tents.jpg',
    ]);

    $order = Order::create([
        'user_id' => $user->id,
        'duration' => 2,
        'status' => Order::STATUS_PENDING,
        'total_price' => 50000,
        'total_fine' => 0,
    ]);

    OrderDetail::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => 1,
    ]);

    $response = $this->actingAs($user)->postJson(route('payment.sync', $order), [
        'transaction_status' => 'settlement',
    ]);

    $response
        ->assertOk()
        ->assertJsonPath('status', Order::STATUS_ON_RENT)
        ->assertJsonPath('redirect_url', route('profile.orders.renting', absolute: false));

    $statusResponse = $this->actingAs($user)->get(route('payment.status', $order));

    $statusResponse
        ->assertOk()
        ->assertViewIs('customer.payment-success')
        ->assertSee('Matras Camping');

    $rentingResponse = $this->actingAs($user)->get(route('profile.orders.renting'));

    $rentingResponse
        ->assertOk()
        ->assertSee('Matras Camping');

    $order->refresh();

    expect($order->status)->toBe(Order::STATUS_ON_RENT)
        ->and($order->loan_date)->not->toBeNull()
        ->and($order->return_date)->not->toBeNull()
        ->and($product->fresh()->stock)->toBe(6)
        ->and($product->fresh()->sold)->toBe(1);
});

it('shows a printable rental invoice for the order owner', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
        'name' => 'Sans Line',
        'no_hp' => '081234567890',
    ]);

    $product = Product::create([
        'name' => 'Tenda Ultralight',
        'description' => 'Tenda ringan',
        'price' => 60000,
        'stock' => 2,
        'sold' => 1,
        'image' => 'products/tents.jpg',
    ]);

    $order = Order::create([
        'user_id' => $user->id,
        'loan_date' => now(),
        'return_date' => now()->addDays(3),
        'duration' => 3,
        'status' => Order::STATUS_ON_RENT,
        'total_price' => 180000,
        'total_fine' => 0,
    ]);

    OrderDetail::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => 1,
    ]);

    $response = $this->actingAs($user)->get(route('profile.orders.invoice', $order));

    $response
        ->assertOk()
        ->assertViewIs('customer.orders.invoice')
        ->assertSee('STRUK PENYEWAAN')
        ->assertSee('Sans Line')
        ->assertSee('Tenda Ultralight')
        ->assertSee('Rp180.000')
        ->assertSee('Cetak Struk');
});

it('does not let customers view another user invoice', function () {
    $owner = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    $otherUser = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $order = Order::create([
        'user_id' => $owner->id,
        'loan_date' => now(),
        'return_date' => now()->addDay(),
        'duration' => 1,
        'status' => Order::STATUS_ON_RENT,
        'total_price' => 50000,
        'total_fine' => 0,
    ]);

    $this->actingAs($otherUser)
        ->get(route('profile.orders.invoice', $order))
        ->assertForbidden();
});

it('shows invoice links on renting and completed order cards', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $rentingOrder = Order::create([
        'user_id' => $user->id,
        'loan_date' => now(),
        'return_date' => now()->addDays(2),
        'duration' => 2,
        'status' => Order::STATUS_ON_RENT,
        'total_price' => 100000,
        'total_fine' => 0,
    ]);

    $completedOrder = Order::create([
        'user_id' => $user->id,
        'loan_date' => now()->subDays(4),
        'return_date' => now()->subDay(),
        'duration' => 3,
        'status' => Order::STATUS_COMPLETED,
        'total_price' => 150000,
        'total_fine' => 0,
    ]);

    $this->actingAs($user)
        ->get(route('profile.orders.renting'))
        ->assertOk()
        ->assertSee(route('profile.orders.invoice', $rentingOrder), false);

    $this->actingAs($user)
        ->get(route('profile.orders.completed'))
        ->assertOk()
        ->assertSee(route('profile.orders.invoice', $completedOrder), false);
});
