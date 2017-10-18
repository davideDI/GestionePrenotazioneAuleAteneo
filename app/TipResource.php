<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipResource extends Model {
    
    protected $table = "tip_resource";
    
    const TIP_RESOURCE_CLASSROOM = 1;
    const TIP_RESOURCE_GYM = 2;
    const TIP_RESOURCE_LABORATORY = 3;
    const TIP_RESOURCE_CONFERENCE_ROOM = 4;
    
    //Relazione con la tabella resources
    public function resources() {
        return $this->hasMany('App\Resource');
    }
    
}
