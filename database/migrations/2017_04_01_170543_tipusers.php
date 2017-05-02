<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Table "tip_user"
class Tipusers extends Migration {
    
    public function up() {
        Schema::create('tip_user', function (Blueprint $table) {
            $table->increments('id')->comment('tip_user id');
            $table->string('name', 20)->comment('tip_user name');
            $table->string('description', 100)->comment('tip_user description');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('tip_user');
    }
    
}
