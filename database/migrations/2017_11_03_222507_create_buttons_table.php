<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateButtonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buttons', function(Blueprint $table){
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->uuid('screen_uuid');
            $table->uuid('button_sub_screen_uuid')->nullable();
            $table->boolean('with_sub_screen');
            $table->uuid('sub_screen_uuid')->nullable();
            $table->smallInteger('width');
            $table->smallInteger('height');
            $table->string('label');
            $table->string('purpose');
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
        Schema::drop('buttons');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
