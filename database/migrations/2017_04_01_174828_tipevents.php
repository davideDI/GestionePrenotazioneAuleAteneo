<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Table tip_event
class Tipevents extends Migration {
    
    public function up() {
        Schema::create('tip_event', function (Blueprint $table) {
            $table->increments('id')->comment('tip_event id');  
            $table->string('name', 20)->comment('tip_event name');  
            $table->string('description', 100)->comment('tip_event description');  
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('tip_event');
    }
    
}
