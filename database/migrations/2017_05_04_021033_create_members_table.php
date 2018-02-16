<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {

            $table->increments('id');
            $table->string('email')->unique();
            $table->string('username');
            $table->string('password');
            $table->uuid('app_uuid');
            $table->dateTime('expiry');
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
        Schema::drop('members');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
