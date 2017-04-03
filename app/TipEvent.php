<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipEvent extends Model {
    
    protected $table = "tip_event";
    
    //Relazione con la tabella events
    public function events() {
        return $this->hasMany('App\Event');
    }
    
}
