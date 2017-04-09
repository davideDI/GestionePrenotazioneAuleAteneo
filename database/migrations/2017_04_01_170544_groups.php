<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Definizione tabella groups
class Groups extends Migration {
    
    public function up() {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('description', 100)->nullable();
            
            //foreign con la tabella tip_group
            $table->integer('tip_group_id')->unsigned();
            $table->foreign('tip_group_id')->references('id')->on('tip_group');
            
            //foreign con la tabella user
            $table->integer('admin_id')->unsigned();
            $table->foreign('admin_id')->references('id')->on('users');
            
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('groups');
    }
    
}
