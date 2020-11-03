<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apps', function(Blueprint $table){
            $table->foreign('user_uuid')->references('uuid')->on('users');
        });

        Schema::table('screens', function(Blueprint $table){
            $table->foreign('app_uuid')->references('uuid')->on('apps');
        });

        Schema::table('texts', function(Blueprint $table){
            $table->foreign('screen_uuid')->references('uuid')->on('screens')->onDelete('cascade');
        });

        Schema::table('images', function(Blueprint $table){
            $table->foreign('screen_uuid')->references('uuid')->on('screens')->onDelete('cascade');
        });

        Schema::table('constraints', function(Blueprint $table){
            $table->foreign('screen_uuid')->references('uuid')->on('screens')->onDelete('cascade');
        });

        Schema::table('members', function (Blueprint $table) {
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
    }
}
