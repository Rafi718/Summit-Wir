<?php

use Tests\TestCase;

uses(TestCase::class);

it('shows success flash notifications on customer pages', function () {
    $response = $this
        ->withSession(['success' => 'Produk ditambahkan ke keranjang!'])
        ->get(route('guide'));

    $response
        ->assertOk()
        ->assertSee('Produk ditambahkan ke keranjang!');
});
