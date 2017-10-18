<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipGroup extends Model {
    
    protected $table = "tip_group";
    
    const TIP_GROUP_GENERIC = 1;
    
    //Relazione con la tabella groups
    public function groups() {
        return $this->hasMany('App\Group');
    }
    
}
