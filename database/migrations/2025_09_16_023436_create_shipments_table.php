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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->char('carrier', 100)->comment('e.g., DHL, FedEx, Lalamove');
            $table->char('tracking_number', 255)->unique()->comment('Provided by carrier');
            $table->enum('status', ['pending', 'shipped', 'in_transit', 'delivered', 'returned'])->default('pending');
            $table->timestamp('shipped_at')->nullable()->comment('When the order was shipped');
            $table->timestamp('delivered_at')->nullable()->comment('When the order was delivered');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
