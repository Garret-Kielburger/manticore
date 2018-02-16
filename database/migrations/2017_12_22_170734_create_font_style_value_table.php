<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFontStyleValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('font_style_values', function (Blueprint $table) {
        $table->increments('id');
        $table->string('value_to_apply');
        $table->string('property_type');
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
        Schema::drop('font_style_values');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
