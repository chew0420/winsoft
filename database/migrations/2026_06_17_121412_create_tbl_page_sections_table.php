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
        Schema::create('tbl_page_sections', function (Blueprint $table) {
            $table->id('section_id');
            $table->unsignedBigInteger('page_id');
            $table->string('section_type');
            $table->string('title')->nullable();
            $table->json('content')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('settings')->nullable();
            $table->timestamps();

            $table->foreign('page_id')->references('page_id')->on('tbl_website_page')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_page_sections');
    }
};
