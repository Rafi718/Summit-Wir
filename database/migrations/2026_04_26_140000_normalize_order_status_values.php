<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('orders')->where('status', 'confirmed')->update(['status' => 'paid']);
        DB::table('orders')->where('status', 'canceled')->update(['status' => 'cancelled']);
    }

    public function down(): void
    {
        // Status values are normalized one-way to avoid reintroducing legacy states.
    }
};
