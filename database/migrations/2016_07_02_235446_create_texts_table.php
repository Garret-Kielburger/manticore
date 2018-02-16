<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('texts', function(Blueprint $table){
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('screen_id');
            $table->uuid('screen_uuid');
            $table->uuid('button_sub_screen_uuid')->nullable();
            $table->string('purpose')->nullable();
            $table->integer('vertical_align')->nullable();
            $table->integer('horizontal_align')->nullable();
            $table->string('content');
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
        Schema::drop('texts');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
