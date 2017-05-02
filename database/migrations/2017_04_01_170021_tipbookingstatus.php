<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Table "tip_booking_status"
class Tipbookingstatus extends Migration {
    
    public function up() {
        Schema::create('tip_booking_status', function (Blueprint $table) {
            $table->increments('id')->comment('tip_booking_status id');
            $table->string('description', 100)->comment('tip_booking_status description');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('tip_booking_status');
    }
    
}
