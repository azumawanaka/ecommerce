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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->comment('Coupon code');
            $table->enum('type', ['fixed', 'percent'])->comment('Coupon type');
            $table->decimal('value', 10, 2)->comment('Discount value');
            $table->decimal('min_order', 10, 2)->comment('Minimum order amount required');
            $table->decimal('max_discount', 10, 2)->nullable()->comment('Max discount (for percentage)');
            $table->integer('usage_limit')->comment('How many times coupon can be used');
            $table->integer('used_count')->default(0)->comment('Counter');
            $table->timestamp('starts_at')->nullable()->comment('Valid from');
            $table->timestamp('ends_at')->nullable()->comment('Valid until');
            $table->enum('status', ['active', 'inactive', 'expired'])->default('active')->comment('Coupon status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
