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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->char('name', 255)->comment('Brand name (e.g., Nike, Apple)');
            $table->char('slug', 255)->comment('URL-friendly version of the brand name');
            $table->char('logo_url', 255)->nullable()->comment('URL to the brand logo image');
            $table->text('description')->nullable()->comment('Detailed description of the brand');
            $table->char('website_url', 255)->nullable()->comment('Official website of the brand');
            $table->boolean('is_active')->default(true)->comment('Indicates if the brand is active/inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
