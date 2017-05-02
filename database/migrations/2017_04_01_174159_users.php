<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Definizione tabella users
class Users extends Migration {
    
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('users id');  
            $table->string('name')->comment('users name');  
            $table->string('surname')->comment('users surname');  
            $table->string('email')->unique()->comment('users email');  
            $table->string('password')->comment('users password');  
            $table->rememberToken()->comment('users remember Token');  
            
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
