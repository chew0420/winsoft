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
        Schema::table('tbl_service_request', function (Blueprint $table) {
            $table->string('device_model', 100)->nullable()->after('device_brand');
            $table->string('service_location', 150)->nullable()->after('service_option');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_service_request', function (Blueprint $table) {
            $table->dropColumn(['device_model', 'service_location']);
        });
    }
};
