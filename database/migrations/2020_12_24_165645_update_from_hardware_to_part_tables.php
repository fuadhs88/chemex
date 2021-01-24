<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFromHardwareToPartTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('hardware_records', 'part_records');
        Schema::rename('hardware_categories', 'part_categories');
        Schema::rename('hardware_tracks', 'part_tracks');
        Schema::table('part_tracks', function (Blueprint $table) {
            $table->renameColumn('hardware_id', 'part_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('part_records', 'hardware_records');
        Schema::rename('part_categories', 'hardware_categories');
        Schema::rename('part_tracks', 'hardware_tracks');
        Schema::table('hardware_tracks', function (Blueprint $table) {
            $table->renameColumn('part_id', 'hardware_id');
        });
    }
}
