<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipUser extends Model {
    
    protected $table = "tip_user";
    
    //Look at TipUser Table
    const ROLE_ADMIN_ATENEO = 1;
    const ROLE_ADMIN_DIP    = 2;
    const ROLE_TEACHER      = 3;
    const ROLE_INQUIRER     = 4;
    const ROLE_SECRETARY    = 5;
    const ROLE_STUDENT      = 6;
    const ROLE_MEMBER       = 7;

    //Relazione con la tabella users
    public function users() {
        return $this->hasMany('App\User');
    }
    
}
