<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Definizione tabella tip_user
class Tipusers extends Migration {
    
    public function up() {
        Schema::create('tip_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20);
            $table->string('description', 100);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('tip_user');
    }
    
}
