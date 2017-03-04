<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    
    public static function store(Event $event) {

        $newEvent = new Event();
        $newEvent->name = $event->name;
        $newEvent->description = $event->description;
        $newEvent->event_date_start = $event->event_date_start;
        $newEvent->event_date_end = $event->event_date_end;
        $newEvent->id_tip_event = $event->id_tip_event;
        $newEvent -> save();
        
    }
    
}
