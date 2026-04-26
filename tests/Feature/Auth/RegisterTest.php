<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

it('registers a user with email and phone then sends whatsapp otp', function () {
    config(['services.fonnte.token' => 'test-token']);

    Http::fake([
        'api.fonnte.com/send' => Http::response([
            'status' => true,
            'detail' => 'success! message in queue',
        ]),
    ]);
    Notification::fake();

    $response = $this->post(route('register.post'), [
        'name' => 'Tester Summit',
        'email' => 'tester@example.test',
        'phone' => '081234567890',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertRedirect(route('whatsapp.verification.notice', absolute: false));
    $this->assertAuthenticated();

    $user = User::where('email', 'tester@example.test')->firstOrFail();

    expect($user->no_hp)->toBe('081234567890');
    expect($user->email_verified_at)->toBeNull();
    expect($user->whatsapp_otp)->not->toBeNull();
    expect($user->whatsapp_otp_expires_at)->not->toBeNull();

    Http::assertSent(fn ($request) => $request->url() === 'https://api.fonnte.com/send'
        && $request->hasHeader('Authorization')
        && $request['target'] === '081234567890'
        && str_contains($request['message'], $user->whatsapp_otp)
        && $request['countryCode'] === '62');
    Notification::assertNothingSent();
});

it('verifies a registered user with a valid whatsapp otp', function () {
    $user = User::factory()->unverified()->create([
        'whatsapp_otp' => '123456',
        'whatsapp_otp_expires_at' => now()->addMinutes(10),
    ]);

    $response = $this->actingAs($user)->post(route('whatsapp.verification.verify'), [
        'otp' => '123456',
    ]);

    $response->assertRedirect(route('home', absolute: false));

    $user->refresh();
    expect($user->hasVerifiedEmail())->toBeTrue();
    expect($user->whatsapp_otp)->toBeNull();
    expect($user->whatsapp_otp_expires_at)->toBeNull();
});
