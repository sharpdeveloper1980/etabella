<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('user_name');
            $table->string('user_password');
            $table->string('user_display_name')->nullable();
            $table->integer('user_last_login')->nullable();
            $table->integer('user_status')->default(1);
            $table->integer('user_level')->nullable();
            $table->integer('user_date_created')->nullable();
            $table->integer('user_date_last_update')->nullable();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
