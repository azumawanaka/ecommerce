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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('provider', 100)->comment('e.g. stripe, paypal, cod, gcash');
            $table->string('transaction_id', 255)->nullable()->comment('Gateway reference ID (nullable for COD)');
            $table->decimal('amount', 10, 2)->comment('Payment amount (can be partial or full)');
            $table->string('currency', 10)->nullable()->comment('e.g. USD, PHP, EUR (optional but useful if multi-currency)');
            $table->enum('status', ['pending', 'success', 'failed', 'refunded'])->default('pending');
            $table->timestamp('paid_at')->nullable()->comment('When payment was confirmed (nullable until success)');
            $table->json('metadata')->nullable()->comment('Gateway response details (auth codes, error messages, etc.)');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
