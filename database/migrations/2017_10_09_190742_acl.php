<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Acl extends Migration {

    public function up() {
        Schema::create('acl', function (Blueprint $table) {
           
            $table->increments('id');
            
            $table->string('cn')->comment('common name from Ldap');
            $table->string('email')->comment('email from Ldap');
            
            //foreign groups table
            $table->integer('group_id')->unsigned()->nullable()->comment('foreign groups table');
            $table->foreign('group_id')->references('id')->on('groups');
            
            //foreign tip_user table
            $table->integer('tip_user_id')->unsigned()->comment('foreign tip_user table');  
            $table->foreign('tip_user_id')->references('id')->on('tip_user');
            
            $table->tinyInteger('enable_access')->default(0)->comment('Flag for access permission'); 
            $table->tinyInteger('enable_crud')->default(0)->comment('Flag for crud permission'); 
            
            $table->timestamps();
            
        });
    }

    public function down() {
        Schema::dropIfExists('acl');
    }    
    
}
