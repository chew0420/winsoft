<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_contact_message', function (Blueprint $table) {
            $table->id('message_id');
            $table->foreignId('customer_id')->nullable()->constrained('tbl_user', 'user_id')->nullOnDelete();
            $table->string('name', 100);
            $table->string('email', 255);
            $table->string('phone', 20)->nullable();
            $table->string('subject', 100);
            $table->text('message');
            $table->enum('status', ['unread', 'read', 'resolved'])->default('unread');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_contact_message');
    }
};