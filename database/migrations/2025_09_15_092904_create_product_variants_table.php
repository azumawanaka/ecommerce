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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('sku', 100)->unique()->comment('Stock Keeping Unit');
            $table->decimal('price', 10, 2)->comment('Base price of the variant');
            $table->decimal('sale_price', 10, 2)->nullable()->comment('Discounted price, if applicable');
            $table->integer('stock_quantity')->comment('Available stock quantity');
            $table->boolean('is_active')->default(true)->comment('Is this variant active for sale?');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
