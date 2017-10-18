<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model {
    
    protected $fillable = [ 'name', 'description', 'capacity',
                            'projector', 'screen_motor', 'screen_manual', 'audio', 'pc', 
                            'wire_mic', 'wireless_mic', 'overhead_projector', 'visual_presenter', 
                            'wiring', 'equipment', 'blackboard', 'note', 'network', 'group_id', 
                            'tip_resource_id'];
    
    //Relazione con la tabella tip_resource
    public function tipResource() {
        return $this->belongsTo('App\TipResource');
    }
    
    //Relazione con la tabella groups
    public function group() {
        return $this->belongsTo('App\Group');
    }
    
    //Relazione con la tabella bookings
    public function bookings() {
        return $this->hasMany('App\Booking');
    }
    
}
