<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateItemCategoriesColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_categories', function (Blueprint $table) {
            $table->integer('parent_id')->default(0);
            $table->string('order')->default(0);
        });
        Schema::table('hardware_categories', function (Blueprint $table) {
            $table->integer('parent_id')->default(0);
            $table->string('order')->default(0);
        });
        Schema::table('software_categories', function (Blueprint $table) {
            $table->integer('parent_id')->default(0);
            $table->string('order')->default(0);
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
            $table->dropColumn('parent_id');
            $table->dropColumn('order');
        });
        Schema::table('hardware_categories', function (Blueprint $table) {
            $table->dropColumn('parent_id');
            $table->dropColumn('order');
        });
        Schema::table('software_categories', function (Blueprint $table) {
            $table->dropColumn('parent_id');
            $table->dropColumn('order');
        });
    }
}
