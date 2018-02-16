<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('styles', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->uuid('screen_uuid');
            $table->uuid('button_sub_screen_uuid');
            $table->uuid('view_object_uuid');
            $table->integer('property_to_style');
            $table->string('value_to_apply');
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
        Schema::drop('styles');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
