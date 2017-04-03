<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Definizione tabella users
class Users extends Migration {
    
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            
            //foreign con la tabella tip_user
            $table->integer('tip_user_id')->unsigned();
            $table->foreign('tip_user_id')->references('id')->on('tip_user');
            
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('users');
    }
    
}
