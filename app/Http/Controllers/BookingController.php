<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Group;
use App\Event;
use App\Booking;

class BookingController extends Controller {

    public function getEventByIdGroup($idGroup) {
        
        $bookings = DB::table('bookings')
            ->select('bookings.name as book_name', 
                     'events.event_date_start as start_date', 
                     'events.event_date_end as end_date',
                     'events.id as id_event')
            ->leftJoin('resources', 'bookings.id_resource', '=', 'resources.id')
            ->leftJoin('groups', 'resources.id_group', '=', 'groups.id')
            ->leftJoin('events', 'bookings.id_event', '=', 'events.id')
            ->where('groups.id', '=', $idGroup)
            ->get();
        
        $resources = DB::table('resources')
            ->select('resources.id', 'resources.name')
            ->leftJoin('groups', 'resources.id_group', '=', 'groups.id')
            ->where('groups.id', '=', $idGroup)
            ->get();
        
        $group = Group::find($idGroup);
        
        return view('pages/index-calendar', [ 'bookings' => $bookings,
                                              'resources' => $resources,
                                              'group' => $group]);
        
    }
    
    public function getEventByIdGroupIdResource($idGroup, $idResource) {
        
        $bookings = DB::table('bookings')
            ->select('bookings.name as book_name', 
                     'events.event_date_start as start_date', 
                     'events.event_date_end as end_date',
                     'events.id as id_event')
            ->leftJoin('resources', 'bookings.id_resource', '=', 'resources.id')
            ->leftJoin('groups', 'resources.id_group', '=', 'groups.id')
            ->leftJoin('events', 'bookings.id_event', '=', 'events.id')
            ->where('groups.id', '=', $idGroup)
            ->where('resources.id', '=', $idResource)
            ->get();
        
        $resources = DB::table('resources')
            ->select('resources.id', 'resources.name')
            ->leftJoin('groups', 'resources.id_group', '=', 'groups.id')
            ->where('groups.id', '=', $idGroup)
            ->get();
        
        $group = Group::find($idGroup);
        
        return view('pages/index-calendar', [ 'bookings' => $bookings,
                                              'resources' => $resources,
                                              'group' => $group]);
        
    }
    
    public function updateEvent() {
        
        //prendo le info dall'array superglobale POST (da ristrutturare)
        $idEvent    = $_POST['id_evento'];
        $startEvent = $_POST['data_inizio'];
        $endEvent   = $_POST['data_fine'];
        
        try {
            //Effettuo l'udate
            DB::table('events')
                        ->where('id', $idEvent)
                        ->update(
                            array
                                ('event_date_start' => $startEvent,
                                 'event_date_end'   => $endEvent)
                        );
            
            $response = array(
                'status' => 'success',
                'msg' => 'A cannone',
            );
            return \Response::json($response);
            
        } catch(Exception $ex) {
            
            $response = array(
                'status' => 'error',
                'msg' => $ex,
            );
            return \Response::json($response);
            
        }
        
    }
    
    public function createNewBooking() {
        
        try {
            
            //prendo le info dall'array superglobale POST (TODO da ristrutturare)
            $name                    = $_POST['name'];
            $description             = $_POST['description'];
            $booking_date_day_start  = $_POST['booking_date_day_start'];
            $booking_date_day_end    = $_POST['booking_date_day_end'];
            $booking_date_hour_start = $_POST['booking_date_hour_start'];
            $booking_date_hour_end   = $_POST['booking_date_hour_end'];
            $resourceSelect          = $_POST['resourceSelect'];
            $groupSelect             = $_POST['groupSelect'];

            //Impostazione parametri evento
            $event = new Event();
            $event->name="";
            $event->description="";
            $event_start_date = $booking_date_day_start." ".$booking_date_hour_start.":00";
            $event_start_end = $booking_date_day_end." ".$booking_date_hour_end.":00";
            $event->event_date_start = $event_start_date;
            $event->event_date_end = $event_start_end;
            $event->id_tip_event = 1;

            //Effettuo l'inserimento di un evento
            $event-> save();

            $booking = new Booking;
            $booking->name = $name;
            $booking->description = $description;
            $booking->booking_date = date('Y-m-d H:i:s');
            $booking->id_user = 5;
            $booking->id_event = $event->id;
            $booking->id_resource = $resourceSelect;
            $booking->id_status = 1;

            //Effettuo l'inserimento della prenotazione
            $booking-> save();
        
            
        } catch(Exception $ex) {
            
            print_r($ex);
            
        }

        return Redirect::back();
        
        /*
        return view('pages/test', [ 'name' => $name,
                                              'description' => $description,
                                              'booking_date_day_start' => $booking_date_day_start,
            'booking_date_day_end' => $booking_date_day_end,
            'booking_date_hour_start' => $booking_date_hour_start,
            'booking_date_hour_end' => $booking_date_hour_end,
            'resourceSelect' => $resourceSelect,
            'groupSelect' => $groupSelect
            ]);
        */
    }

}