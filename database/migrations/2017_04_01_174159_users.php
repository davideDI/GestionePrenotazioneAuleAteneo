<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Definizione tabella users
class Users extends Migration {
    
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('user id');  
            $table->string('name')->comment('user name');  
            $table->string('surname')->comment('user surname');  
            $table->string('email')->unique()->comment('user email');  
            $table->string('password')->comment('user password');  
            $table->rememberToken()->comment('user remember Token');  
            
            //foreign tip_user table
            $table->integer('tip_user_id')->unsigned()->comment('foreign tip_user table');  
            $table->foreign('tip_user_id')->references('id')->on('tip_user');
            
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('users');
    }
    
}
