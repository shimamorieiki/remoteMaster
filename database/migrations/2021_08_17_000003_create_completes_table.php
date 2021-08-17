<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompletesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('completes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->unique();            
            // $table->foreignId('user_id')->constrained();
            // $table->foreignId('task_id')->constrained();
            $table->integer('user_id')->unsigned();// 符号無し属性に変更
            $table->foreign('user_id')->references('id')->on('users');  
            $table->integer('task_id')->unsigned();// 符号無し属性に変更
            $table->foreign('task_id')->references('id')->on('tasks');  

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('completes');
    }
}
