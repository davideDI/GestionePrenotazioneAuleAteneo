<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {
    
    protected $fillable = ['name', 'description', 'tip_group_id'];
    
    //Relazione con la tabella tip_group
    public function tipGroup() {
        return $this->belongsTo('App\TipGroup');
    }
    
    //Relazione con la tabella resources
    public function resources() {
        return $this->hasMany('App\Resource');
    }
       
}
