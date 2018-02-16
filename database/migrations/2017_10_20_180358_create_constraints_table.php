<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConstraintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constraints', function(Blueprint $table){
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->uuid('screen_uuid');
            $table->uuid('button_sub_screen_uuid');
            $table->uuid('start_id');
            $table->string('start_side');
            $table->uuid('end_id');
            $table->string('end_side');
            $table->integer('margin');
            $table->boolean('horizontally_centered');
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
        Schema::drop('constraints');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
