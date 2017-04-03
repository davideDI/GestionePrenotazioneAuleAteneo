<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Definizione tabella tip_resource
class Tipresources extends Migration {
    
    public function up() {
        Schema::create('tip_resource', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20);
            $table->string('description', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tip_resource');
    }
    
}
