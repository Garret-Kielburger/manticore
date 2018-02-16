<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_views', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->uuid('screen_uuid');
            $table->string('web_address');
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
        Schema::drop('web_views');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
