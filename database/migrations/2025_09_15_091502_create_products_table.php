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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->char('name', 255)->comment('Product name');
            $table->char('slug', 255)->unique()->comment('SEO URL');
            $table->text('description')->comment('Product description');
            $table->text('short_description')->nullable()->comment('For listing / preview');
            $table->bigInteger('category_id')->unsigned()->comment('Foreign key to categories table');
            $table->bigInteger('brand_id')->unsigned()->nullable()->comment('Foreign key to brands table');
            $table->decimal('price', 10, 2)->comment('Base price');
            $table->decimal('sale_price', 10, 2)->nullable()->comment('Discounted price');
            $table->integer('stock_quantity')->default(0)->comment('Inventory count');
            $table->string('sku', 100)->unique()->nullable()->comment('Stock Keeping Unit');
            $table->boolean('is_active')->default(true)->comment('Is the product active?');
            $table->boolean('is_featured')->default(false)->comment('Is the product featured?');
            $table->char('meta_title', 255)->nullable()->comment('SEO Meta Title');
            $table->text('meta_description')->nullable()->comment('SEO Meta Description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
