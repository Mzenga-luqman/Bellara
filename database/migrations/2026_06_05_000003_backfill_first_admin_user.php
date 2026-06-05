<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $hasAdmin = DB::table('users')->where('is_admin', true)->exists();

        if (! $hasAdmin) {
            DB::table('users')
                ->orderBy('id')
                ->limit(1)
                ->update(['is_admin' => true]);
        }
    }

    public function down(): void
    {
        // Intentionally no-op to avoid removing intentional admin assignments.
    }
};
