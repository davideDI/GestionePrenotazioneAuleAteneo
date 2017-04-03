<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipResource extends Model {
    
    protected $table = "tip_resource";
    
    //Relazione con la tabella resources
    public function resources() {
        return $this->hasMany('App\Resource');
    }
    
}