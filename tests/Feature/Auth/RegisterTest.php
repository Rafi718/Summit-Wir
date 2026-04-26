<?php

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

it('registers a user with phone number and redirects to email verification notice', function () {
    Notification::fake();

    $response = $this->post(route('register.post'), [
        'name' => 'Tester Summit',
        'email' => 'tester@example.test',
        'phone' => '081234567890',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertRedirect(route('verification.notice', absolute: false));
    $this->assertAuthenticated();

    $user = User::where('email', 'tester@example.test')->firstOrFail();

    expect($user->no_hp)->toBe('081234567890');
    Notification::assertSentTo($user, VerifyEmail::class);
});
