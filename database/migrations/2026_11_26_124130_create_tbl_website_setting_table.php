<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_website_setting', function (Blueprint $table) {
            $table->id('setting_id');
            $table->string('website_name', 100)->default('Winsoft Solutions');
            $table->string('website_logo')->default('img/winsoftlogo.png');
            $table->string('favicon')->nullable();
            $table->timestamps();
        });

        DB::table('tbl_website_setting')->insert([
            'setting_id' => 1,
            'website_name' => 'Winsoft Solutions',
            'website_logo' => 'img/winsoftlogo.png',
            'favicon' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_website_setting');
    }
};