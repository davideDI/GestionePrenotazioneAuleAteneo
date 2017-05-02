<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Table "tip_group"
class Tipgroups extends Migration {
   
    public function up() {
        Schema::create('tip_group', function (Blueprint $table) {
            $table->increments('id')->comment('tip_group id');
            $table->string('name', 20)->comment('tip_group name');
            $table->string('description', 100)->comment('tip_group description');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('tip_group');
    }
    
}
