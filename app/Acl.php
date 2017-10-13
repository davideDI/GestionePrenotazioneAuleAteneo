<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acl extends Model {
    
    protected $fillable = ['email', 'cn', 'group_id', 'tip_user_id', 'enable_access', 'enable_crud'];
    protected $table = 'acl';
    
    //Relazione con la tabella groups
    public function group() {
        return $this->belongsTo('App\Group');
    }
    
    //Relazione con la tabella tip_user
    public function tipUser() {
        return $this->belongsTo('App\TipUser');
    }
    
}
