<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function(Blueprint $table){
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->string('app_name');
            $table->string('app_api_key')->nullable();
            $table->integer('user_id')->unsigned();
            $table->uuid('user_uuid');
/*          $table->integer('screen_id');
            $table->integer('screen_uuid')->nullable();*/
            $table->string('action_bar_colour')->nullable();
            $table->string('system_bar_colour')->nullable();
            $table->integer('navigation_id')->nullable();
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
        Schema::drop('apps');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
