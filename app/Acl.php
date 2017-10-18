<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acl extends Model {
    
    protected $fillable = ['name', 'surname', 'group_id', 'user_id', 'enable_access', 'enable_crud'];
    protected $table = 'acl';
    
    //Relazione con la tabella groups
    public function group() {
        return $this->belongsTo('App\Group');
    }
    
    //Relazione con la tabella tip_user
    public function user() {
        return $this->belongsTo('App\User');
    }
    
}
