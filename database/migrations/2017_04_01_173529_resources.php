<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Definizione tabella resources
class Resources extends Migration {
    
    public function up() {
        Schema::create('resources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('description', 100)->nullable();
            
            //foreign con la tabella groups
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('groups');
            
            //foreign con la tabella tip_resource
            $table->integer('tip_resource_id')->unsigned();
            $table->foreign('tip_resource_id')->references('id')->on('tip_resource');
            
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('resources');
    }
    
}
