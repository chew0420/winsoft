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
        //
        Schema::create('tbl_product', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('name', 200);
            $table->decimal('price', 10, 2);
            $table->text('description')->nullable();
            $table->string('image', 255)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->integer('min_stock_level')->default(5);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('category_id')->nullable()->constrained('tbl_category', 'category_id')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('tbl_product');
    }
};
