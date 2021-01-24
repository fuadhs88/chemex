<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateItemsAssetNumberColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_records', function (Blueprint $table) {
            $table->string('asset_number')->nullable()->unique();
        });
        Schema::table('hardware_records', function (Blueprint $table) {
            $table->string('asset_number')->nullable()->unique();
        });
        Schema::table('software_records', function (Blueprint $table) {
            $table->string('asset_number')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device_records', function (Blueprint $table) {
            $table->dropColumn('asset_number');
        });
        Schema::table('hardware_records', function (Blueprint $table) {
            $table->dropColumn('asset_number');
        });
        Schema::table('software_records', function (Blueprint $table) {
            $table->dropColumn('asset_number');
        });
    }
}
