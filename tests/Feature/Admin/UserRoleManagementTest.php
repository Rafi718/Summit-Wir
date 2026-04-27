<?php

use App\Models\User;

it('lets an admin promote a user to admin from the admin user edit form', function () {
    $admin = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'admin',
    ]);
    $user = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'user',
        'name' => 'Calon Admin',
        'email' => 'calon-admin@example.test',
        'no_hp' => '081234567890',
    ]);

    $response = $this->actingAs($admin)->put(route('admin.users.update', $user), [
        'name' => $user->name,
        'email' => $user->email,
        'no_hp' => $user->no_hp,
        'role' => 'admin',
    ]);

    $response
        ->assertRedirect(route('admin.users.show', $user, absolute: false))
        ->assertSessionHas('success');

    expect($user->fresh()->role)->toBe('admin');
});

it('prevents an admin from changing their own role', function () {
    $admin = User::factory()->create([
        'email_verified_at' => now(),
        'role' => 'admin',
        'name' => 'Admin Aktif',
        'email' => 'admin-aktif@example.test',
        'no_hp' => '081234567891',
    ]);

    $response = $this->actingAs($admin)->put(route('admin.users.update', $admin), [
        'name' => $admin->name,
        'email' => $admin->email,
        'no_hp' => $admin->no_hp,
        'role' => 'user',
    ]);

    $response
        ->assertRedirect(route('admin.users.edit', $admin, absolute: false))
        ->assertSessionHasErrors('role');

    expect($admin->fresh()->role)->toBe('admin');
});
