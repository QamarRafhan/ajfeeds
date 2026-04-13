<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->id();

            // Relationships
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();

            // Order Info
            $table->string('reference_no')->unique();
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');

            // Amounts
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);

            // Payment
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid');

            $table->timestamps();
            $table->softDeletes()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
