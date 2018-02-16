<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateButtonsSubScreensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buttons_sub_screens', function(Blueprint $table){
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->uuid('screen_uuid');
            $table->string('owning_button_uuid')->nullable();
            $table->string('title');
            $table->string('purpose');
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
        Schema::drop('buttons_sub_screens');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
