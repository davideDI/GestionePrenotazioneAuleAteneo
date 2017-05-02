<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Table "tip_resource"
class Tipresources extends Migration {
    
    public function up() {
        Schema::create('tip_resource', function (Blueprint $table) {
            $table->increments('id')->comment('tip_resource id');
            $table->string('name', 20)->comment('tip_resource name');
            $table->string('description', 100)->comment('tip_resource description');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('tip_resource');
    }
    
}
