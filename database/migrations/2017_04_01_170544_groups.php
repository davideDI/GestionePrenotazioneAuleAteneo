<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Table groups
class Groups extends Migration {
    
    public function up() {
        Schema::create('groups', function (Blueprint $table) {
            
            $table->increments('id')->comment('group id');
            
            $table->string('name', 50)->comment('group name');
            $table->string('description', 100)->nullable()->comment('group description');
            
            //foreign tip_group table
            $table->integer('tip_group_id')->unsigned()->comment('foreign tip_group table');
            $table->foreign('tip_group_id')->references('id')->on('tip_group');
            
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('groups');
    }
    
}
