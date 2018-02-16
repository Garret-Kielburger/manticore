<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScreensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screens', function(Blueprint $table){
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->string('screen_name');
            $table->integer('screen_order_number');
            $table->integer('app_id')->unsigned();
            $table->uuid('app_uuid');
/*          $table->string('content_type'); // text/image/etc.
            $table->integer('content_id');
            $table->integer('content_uuid');*/
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
        Schema::drop('screens');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
