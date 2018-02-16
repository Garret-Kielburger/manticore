<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGcmUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcm_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('deviceId')->unique();
            $table->text('regId');
            $table->uuid('app_uuid');
            $table->timestamps();
        });


        Schema::table('gcm_users', function(Blueprint $table){
            $table->foreign('app_uuid')->references('uuid')->on('apps');
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
        Schema::drop('gcm_users');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }

}
