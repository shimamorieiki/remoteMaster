<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            // $table->foreignid('role_id')->constrained()
            $table->integer('role_id')->unsigned();// 符号無し属性に変更
            $table->foreign('role_id')->references('id')->on('roles');  
            // $table->string('api_token', 80)->after('password')
            //     ->unique()
            //     ->nullable()
            //     ->default(null);
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
