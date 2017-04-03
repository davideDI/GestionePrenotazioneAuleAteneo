<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Definizione tabella tip_booking_status
class Tipbookingstatus extends Migration {
    
    public function up() {
        Schema::create('tip_booking_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description', 100);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('tip_booking_status');
    }
    
}
