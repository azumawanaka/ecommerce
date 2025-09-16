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
            $table->unsignedBigInteger('user_id')->nullable()->comment('If guest checkout, nullable');
            $table->char('status', 50)->default('pending')->comment('pending, paid, shipped, delivered, cancelled');
            $table->decimal('total_amount', 10, 2)->comment('Final total amount charged to customer');
            $table->decimal('subtotal_amount', 10, 2)->default(0)->comment('Before tax/shipping/discount');
            $table->decimal('discount_amount', 10, 2)->nullable()->comment('Total discounts applied');
            $table->decimal('shipping_amount', 10, 2)->comment('Shipping fee');
            $table->decimal('tax_amount', 10, 2)->comment('Tax applied');
            $table->char('payment_status', 50)->default('pending')->comment('pending, paid, failed, refunded');
            $table->char('payment_method', 100)->default('cod')->comment('cod, paypal, strpi, gcash');
            $table->unsignedBigInteger('shipping_address_id')->nullable()->comment('From user_addresses FK -> order_addresses.id');
            $table->unsignedBigInteger('billing_address_id')->nullable()->comment('From user_addresses FK -> order_addresses.id');
            $table->timestamp('placed_at')->useCurrent()->comment('When order placed');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
