<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateItemCategoriesParentIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_categories', function (Blueprint $table) {
            $table->integer('parent_id')->nullable()->default(null)->change();
        });
        Schema::table('part_categories', function (Blueprint $table) {
            $table->integer('parent_id')->nullable()->default(null)->change();
        });
        Schema::table('software_categories', function (Blueprint $table) {
            $table->integer('parent_id')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device_categories', function (Blueprint $table) {
            $table->integer('parent_id')->default(0)->change();
        });
        Schema::table('part_categories', function (Blueprint $table) {
            $table->integer('parent_id')->default(0)->change();
        });
        Schema::table('software_categories', function (Blueprint $table) {
            $table->integer('parent_id')->default(0)->change();
        });
    }
}
