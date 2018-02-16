<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavigationStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigation_styles', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->uuid('app_uuid');
            $table->string('start_colour');
            $table->string('end_colour');
            $table->string('background_colour'); // also centre colour in Navigation Drawer
            $table->string('title');
            $table->string('subtitle');
            $table->string('text_colour');
            $table->string('text_highlight_colour');
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
        Schema::drop('navigation_styles');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
