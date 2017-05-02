<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Table resources
class Resources extends Migration {
    
    public function up() {
        Schema::create('resources', function (Blueprint $table) {
            $table->increments('id')->comment('resource id');  
            $table->string('name', 50)->comment('resource name');  
            $table->string('description', 100)->nullable()->comment('resource description');  
            
            //Caratteristiche Risorsa
            $table->integer('capacity')->default(0)->comment('Proiettore?');     
            //`room_admin_email` text,
            //`custom_html` text,
            $table->tinyInteger('projector')->default(0)->comment('Projector?');           
            $table->tinyInteger('screen_motor')->default(0)->comment('Screen Motor?');
            $table->tinyInteger('screen_manual')->default(0)->comment('Screen manual?');
            $table->tinyInteger('audio')->default(0)->comment('Imp. Audio?');
            $table->tinyInteger('pc')->default(0)->comment('PC?');
            $table->tinyInteger('wire_mic')->default(0)->comment('wire Mic?');
            $table->tinyInteger('wireless_mic')->default(0)->comment('Wireless Mic?');
            $table->tinyInteger('overhead_projector')->default(1)->comment('Overhead Projector?');
            $table->tinyInteger('visual_presenter')->default(0)->comment('Visual Presenter?'); 
            $table->tinyInteger('wiring')->default(1)->comment('Wiring?'); 
            $table->tinyInteger('equipment')->default(1)->comment('Equipment?'); 
            $table->string('blackboard', 10)->default('N.D.')->comment('Blackboard type'); 
            $table->string('note', 50)->default('')->comment('Note'); 
            $table->integer('network')->default(1)->comment('Num network');
            
            //foreign groups table
            $table->integer('group_id')->unsigned()->comment('foreign groups table');
            $table->foreign('group_id')->references('id')->on('groups');
            
            //foreign tip_resource table
            $table->integer('tip_resource_id')->unsigned()->comment('foreign tip_resource table');
            $table->foreign('tip_resource_id')->references('id')->on('tip_resource'); 
          
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('resources');
    }
    
}
