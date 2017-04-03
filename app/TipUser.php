<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipUser extends Model {
    
    protected $table = "tip_user";
    
    //Relazione con la tabella users
    public function users() {
        return $this->hasMany('App\User');
    }
    
}