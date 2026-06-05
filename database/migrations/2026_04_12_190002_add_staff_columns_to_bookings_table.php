<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('preferred_staff_id')->nullable()->after('service_id')->constrained('staff')->nullOnDelete();
            $table->foreignId('staff_id')->nullable()->after('preferred_staff_id')->constrained('staff')->nullOnDelete();
            $table->index(['booking_date', 'staff_id']);
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['booking_date', 'staff_id']);
            $table->dropConstrainedForeignId('staff_id');
            $table->dropConstrainedForeignId('preferred_staff_id');
        });
    }
};
