<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateButtonStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('button_styles', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->uuid('screen_uuid');
            $table->uuid('button_sub_screen_uuid')->nullable();
            $table->uuid('view_object_uuid');
            $table->string('text_size')->nullable();
            $table->string('text_color')->nullable();
            $table->string('text_style')->nullable();
            $table->string('font_family')->nullable();
            $table->string('background_color')->nullable();

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
        Schema::dropIfExists('button_styles');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
