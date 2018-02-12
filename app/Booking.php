<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {

    protected $fillable = ['name', 'description', 'teacher_id', 'subject_id', 'cds_id', 'num_students', 'booking_date', 'resource_id', 'tip_event_id'];
    protected $table = 'bookings';

    //Relazione con la tabella repeats
    public function repeats() {
        return $this->hasMany('App\Repeat');
    }

    //Relazione con la tabella users
    public function user() {
        return $this->belongsTo('App\User');
    }

    //Relazione con la tabella resources
    public function resource() {
        return $this->belongsTo('App\Resource');
    }

    //Relazione con la tabella tip_event
    public function tipEvent() {
        return $this->belongsTo('App\TipEvent');
    }

}
