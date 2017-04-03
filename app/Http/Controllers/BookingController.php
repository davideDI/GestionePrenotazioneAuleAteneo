<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Group;
use App\Event;
use App\Booking;

class BookingController extends Controller {

    //Lista di tutte le prenotazioni per id group
    public function getBookingsByIdGroup($idGroup) {
        
        Log::info('BookingController - getBookingsByIdGroup('.$idGroup.')');
        
        $group = \App\Group::find($idGroup);
        $resources = $group->resources;

        $listIdResource = array();
        foreach ($resources as $resource) {
            array_push($listIdResource, $resource->id);
        }
        $bookings = \App\Booking::whereIn('resource_id', $listIdResource)->get();
        
        return view('pages/index-calendar', [ 'resources' => $resources, 'group' => $group, 'bookings' => $bookings]);
        
    }
    
    public function getBookingsByIdGroupIdResource($idGroup, $idResource) {
        
        Log::info('BookingController - getBookingsByIdGroupIdResource('.$idGroup.', '.$idResource.')');
        
        $group = \App\Group::find($idGroup);
        $resources = $group->resources;
        $resource = \App\Resource::find($idResource);
        $bookings = \App\Booking::where('resource_id', '=', $idResource)->get();
        
        return view('pages/index-calendar', [ 'bookings' => $bookings,
                                              'resource' => $resource,
                                              'resources' => $resources,
                                              'group' => $group]);
        
    }
    
    public function updateEvent() {
        
        Log::info('BookingController - updateEvent()');
        
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
            
            Log::error('BookingController - updateEvent() : '.$ex);
            $response = array(
                'status' => 'error',
                'msg' => $ex,
            );
            return \Response::json($response);
            
        }
        
    }
    
    public function createNewBooking() {
        
        Log::info('BookingController - createNewBooking()');
        
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
            
            Log::error('BookingController - createNewBooking() : '.$ex);
            
        }

        return Redirect::back();
        
    }

}