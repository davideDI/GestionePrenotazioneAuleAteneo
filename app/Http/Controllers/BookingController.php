<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class BookingController extends Controller {

    public function insertNewBooking(Request $request) {
        
        date_default_timezone_set('Europe/Rome');
    
        //TODO
        //Sviluppare validazione campi

        Log::info('BookingController - insertNewBooking()');

        try {

            //Booking Object
            $booking = new \App\Booking; 
            $booking->fill($request->all());

            //Repeat Object
            $repeat = new \App\Repeat;
            $repeat->fill($request->all());

            //Resource Object
            $resourceOfBooking = \App\Resource::find($booking->resource_id);

            $booking->booking_date = date("Y-m-d G:i:s");
            $booking->user_id = session('source_id');
            Log::info('BookingController - Insert booking ['.$booking.']');
            $booking->save();

            $typeOfRepeat = $request['repeat_event'];

            //Single event
            if($typeOfRepeat == 1) {

                $repeat_start_string = $repeat->event_date_start.":00";
                $repeat_end_string = $repeat->event_date_end.":00";
                $repeat_start = date("Y-m-d G:i:s",strtotime($repeat_start_string));
                $repeat_end = date("Y-m-d G:i:s",strtotime($repeat_end_string));

                $repeat->event_date_start = $repeat_start;
                $repeat->event_date_end = $repeat_end;
                $repeat->tip_booking_status_id = 1;
                $repeat->booking_id= $booking->id;
                Log::info('BookingController - Insert repeat ['.$repeat.']');
                $repeat->save();

            } 

            //Multiple event
            if($typeOfRepeat == 2) {

                $test = array();

                //data inizio ripetizione
                $repeat_start_string = substr($repeat->event_date_start, 0, 10)." 00:00";
                $repeat_start = date("d-m-Y G:i:s",strtotime($repeat_start_string));

                //data fine ripetizione
                $repeat_end_string = substr($repeat->event_date_end, 0, 10)." 23:59";
                $repeat_end = date("d-m-Y G:i:s",strtotime($repeat_end_string));

                $weekRepeats = $request['type_repeat'];
                $coutnWeekRepeats = count($weekRepeats);

                if($weekRepeats != null && $coutnWeekRepeats > 0) {

                    $dayofweekStartEvent = date('w', strtotime($repeat_start));

                    for($i = 0; $i < $coutnWeekRepeats; $i++) {

                        $newdate = strtotime ( $weekRepeats[$i].' day' , strtotime ( $repeat_start ) ) ; // facciamo l'operazione
                        $newdate = date ( 'd-m-Y G:i:s', $newdate ); //trasformiamo la data nel formato accettato dal db YYYY-MM-DD
                        $dayofweekRepeatTemp = date('w', strtotime($newdate));

                        if($dayofweekStartEvent < $dayofweekRepeatTemp) {
                            if($newdate <= $repeat_end) {
                                array_push($test, $newdate);
                            }
                        }

                    }


                }


                /*
                if($weekRepeats != null && count($weekRepeats) > 0) {
                    for($i = 0; $i < count($weekRepeats); $i++) {
                        $multipleRepeat = new App\Repeat;

                            //$dayofweek = date('w', strtotime($date));
                            //$result    = date('Y-m-d', strtotime(($day - $dayofweek).' day', strtotime($date))); 

                        $multipleRepeat->dayofweek = date('w', strtotime($repeat_start_string));
                        $multipleRepeat->dayofweek2 = date('w', strtotime($repeat_end_string));


                        $multipleRepeat->booking_id= $booking->id;
                        $multipleRepeat->tip_booking_status_id = 1;
                        $date_from = 'detail_day_from_'.$weekRepeats[$i];
                        $date_to = 'detail_day_to_'.$weekRepeats[$i];
                        $multipleRepeat->day = $weekRepeats[$i];
                        $multipleRepeat->from = $request[$date_from];
                        $multipleRepeat->to = $request[$date_to];
                        array_push($test, $multipleRepeat);
                    }
                }
                */
                return view('pages/testInsert', ['testDate' => $test]);

            }

            return redirect()->route('bookings2', [$resourceOfBooking->group_id, $booking->resource_id])->with('success', 100);
            
        } catch(Exception $ex) {
            Log::error('BookingController - Errore nell\'inserimento della prenotazione '.$ex->getMessage());
            return Redirect::back()->withErrors([500]);
        }
        
    }
    
    public function getListOfResourcesByIdGroup() {
        
        $idGroup = $_POST['idGroup'];
        Log::info('BookingController - getListOfResourcesByIdGroup('.$idGroup.')');
        return \App\Resource::where('group_id', '=', $idGroup)->select('name as text', 'id')->get();
        
    }
    
    public function getSpecificResource() {
        
        $idResource = $_POST['id_resource'];
        Log::info('BookingController - getSpecificResource('.$idResource.')');
        return \App\Resource::find($idResource);
        
    }
    
    public function getNewBookingForm() {
        
        Log::info('BookingController - getNewBookingForm()');
    
        $booking = new \App\Booking;
        $groupsList = \App\Group::pluck('name', 'id');
        $resourceList =  \App\Resource::pluck('name', 'id');
        $tipEventList = \App\TipEvent::pluck('name', 'id');
        
        $listOfTeachings = "";
        if(session('ruolo') == 'docente') {
            $listOfTeachings = new \Illuminate\Support\Collection(session('listOfTeachings'));
        }

        return view('pages/new-booking', [  'booking'      => $booking,
                                            'groupsList'   => $groupsList,
                                            'resourceList' => $resourceList,
                                            'tipEventList' => $tipEventList,
                                            'listOfTeachings' => $listOfTeachings]);
        
    }
    
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
