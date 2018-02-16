<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function(Blueprint $table){
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('screen_id');
            $table->uuid('screen_uuid');
            $table->uuid('button_sub_screen_uuid')->nullable();
            $table->string('purpose')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('uri');
            $table->integer('vertical_align')->nullable();
            $table->string('delete_uri');
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
        Schema::drop('images');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
