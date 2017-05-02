<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller {

    //Lista di tutte le prenotazioni per id group
    public function getBookingsByIdGroup($idGroup) {
        
        Log::info('BookingController - getBookingsByIdGroup('.$idGroup.')');
        
        $group = \App\Group::find($idGroup);
        $resources = $group->resources;
        $firstResource = $resources->first();
        $bookings = \App\Booking::where('resource_id', $firstResource->id)->get();
        $eventsType = \App\TipEvent::all();
        $bookingsStatus = \App\TipBookingStatus::all();
        
        return view('pages/index-calendar', [ 'selectedResource' => $firstResource,
                                              'resources'    => $resources, 
                                              'group'        => $group,
                                              'eventsType'   => $eventsType,
                                              'bookingsStatus'=> $bookingsStatus,
                                              'bookings'     => $bookings]);
        
    }
    
    //Lista di tutte le prenotazioni per id group e id resource
    public function getBookingsByIdGroupIdResource($idGroup, $idResource) {
        
        Log::info('BookingController - getBookingsByIdGroupIdResource('.$idGroup.', '.$idResource.')');
        
        $group = \App\Group::find($idGroup);
        $resources = $group->resources;
        $resource = \App\Resource::find($idResource);
        $bookings = \App\Booking::where('resource_id', '=', $idResource)->get();
        $eventsType = \App\TipEvent::all();
        $bookingsStatus = \App\TipBookingStatus::all();
        
        return view('pages/index-calendar', [ 'bookings' => $bookings,
                                              'selectedResource' => $resource,
                                              'resources' => $resources,
                                              'eventsType'   => $eventsType,
                                              'bookingsStatus'=> $bookingsStatus,
                                              'group' => $group]);
        
    }
    
    //metodo di test per l'update di una prenotazione tramite drug&drop o resize (disabilitato)
    //TODO da modificare campi viste le modifiche alle tabelle
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

}
