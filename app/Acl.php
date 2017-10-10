<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acl extends Model {
    
    protected $fillable = ['email', 'cn', 'group_id', 'tip_user_id', 'enable_access', 'enable_crud'];
    protected $table = 'acl';
    
}
