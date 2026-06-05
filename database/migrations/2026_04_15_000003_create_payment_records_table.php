<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->string('method'); // 'mpesa', 'card', 'cash'
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('pending'); // 'pending', 'completed', 'failed'
            $table->string('transaction_id')->nullable()->unique();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->index(['booking_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_records');
    }
};
