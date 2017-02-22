<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Group;

class BookingController extends Controller {

    public function getGroupById($idGroup) {
        
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

}