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
        Schema::create('tbl_service_request', function (Blueprint $table) {
            $table->id('request_id');
            $table->foreignId('customer_id')->constrained('tbl_user', 'user_id')->onDelete('cascade');
            $table->foreignId('technician_id')->nullable()->constrained('tbl_user', 'user_id')->onDelete('set null');
            $table->string('service_type', 50);
            $table->enum('service_option', ['door-to-door', 'walk-in']);
            $table->text('problem_description')->nullable();
            $table->string('device_type', 50)->nullable();
            $table->string('device_brand', 50)->nullable();
            $table->text('address')->nullable();
            $table->date('preferred_date')->nullable();
            $table->string('preferred_time', 50)->nullable();
            $table->enum('status', ['pending', 'confirmed', 'in-progress', 'completed', 'cancelled'])->default('pending');
            $table->decimal('quotation', 10, 2)->nullable();
            $table->decimal('final_price', 10, 2)->nullable();
            $table->text('technician_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('tbl_service_request');
    }
};
