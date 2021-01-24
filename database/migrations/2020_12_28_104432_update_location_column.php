<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLocationColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_records', function (Blueprint $table) {
            $table->string('location')->nullable();
        });
        Schema::table('part_records', function (Blueprint $table) {
            $table->string('location')->nullable();
        });
        Schema::table('software_records', function (Blueprint $table) {
            $table->string('location')->nullable();
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
            $table->dropColumn('location');
        });
        Schema::table('part_records', function (Blueprint $table) {
            $table->dropColumn('location');
        });
        Schema::table('software_records', function (Blueprint $table) {
            $table->dropColumn('location');
        });
    }
}
