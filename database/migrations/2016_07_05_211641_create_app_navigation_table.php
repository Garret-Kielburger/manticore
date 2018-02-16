<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppNavigationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_navigation', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('app_id');
            $table->integer('app_uuid')->nullable();
            $table->integer('navigation_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('app_navigation');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
