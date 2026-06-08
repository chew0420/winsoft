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
        Schema::create('tbl_payment', function (Blueprint $table) {
            $table->id('payment_id');
            $table->foreignId('order_id')->constrained('tbl_order', 'order_id')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->datetime('payment_date');
            $table->enum('payment_method', ['credit_card', 'debit_card', 'online_banking', 'e_wallet', 'others']);
            $table->string('transaction_id', 100)->unique();
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('tbl_payment');
    }
};
