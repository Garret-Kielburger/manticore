<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyToStyleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties_to_style', function (Blueprint $table) {
            $table->increments('id');
            $table->string('property_to_style');
            $table->string('element_type'); // button, text, image, etc. if > 1, then button_text alphabetical
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
        Schema::drop('properties_to_style');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
