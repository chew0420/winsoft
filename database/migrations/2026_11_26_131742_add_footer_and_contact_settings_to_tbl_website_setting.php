<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_website_setting', function (Blueprint $table) {
            $table->text('footer_description')->nullable();
            $table->string('copyright_text', 255)->default('Winsoft Solutions Sdn Bhd. All rights reserved.');

            $table->text('contact_address')->nullable();
            $table->string('contact_phone', 30)->nullable();
            $table->string('contact_email', 255)->nullable();

            $table->string('facebook_url', 500)->nullable();
            $table->string('instagram_url', 500)->nullable();
            $table->string('whatsapp_number', 30)->nullable();

            $table->boolean('show_footer_brand')->default(true);
            $table->boolean('show_footer_links')->default(true);
            $table->boolean('show_footer_contact')->default(true);
            $table->boolean('show_footer_social')->default(true);
        });

        \Illuminate\Support\Facades\DB::table('tbl_website_setting')->where('setting_id', 1)->update([
            'footer_description' => 'Your trusted IT partner for technology products, professional services and reliable support.',
            'contact_address' => '17, Jalan Cempaka 1, Taman Bunga Cempaka Biru, 86400 Parit Raja, Johor',
            'contact_phone' => '012-3456789',
            'contact_email' => 'tiam@winsoft.com.my'
        ]);
    }

    public function down(): void
    {
        Schema::table('tbl_website_setting', function (Blueprint $table) {
            $table->dropColumn([
                'footer_description',
                'copyright_text',
                'contact_address',
                'contact_phone',
                'contact_email',
                'facebook_url',
                'instagram_url',
                'whatsapp_number',
                'show_footer_brand',
                'show_footer_links',
                'show_footer_contact',
                'show_footer_social'
            ]);
        });
    }
};