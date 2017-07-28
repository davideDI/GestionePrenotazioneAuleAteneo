<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Exception;

class BookingController extends Controller {

    public function getBooking(Request $request) {
        
        $bookingId = $request['booking_id'];
        Log::info('BookingController - getBooking(bookingId: '.$bookingId.')');
        $booking = \App\Booking::with('repeats', 'tipEvent', 'repeats.surveys')->where('id', $bookingId)->get();
        return $booking;
        
    }
    
    public function insertNewBooking(Request $request) {
        
        date_default_timezone_set('Europe/Rome');
    
        //TODO
        //Sviluppare validazione campi

        Log::info('BookingController - insertNewBooking()');

        try {
            
            //TODO valida formato data inizio / fine
            //TODO valida capienza prevista e massima aula
            $this->validate($request, [
                'name'             => 'required|max:50',
                'description'      => 'required|max:100',
                'num_students'     => 'required|numeric|min:1',
                'event_date_start' => 'required',
                'event_date_end'   => 'required',
                'resource_id'      => 'required|numeric' 
            ]);
            
            //Booking Object
            $booking = new \App\Booking; 
            $booking->fill($request->all());

            //Repeat Object
            $repeat = new \App\Repeat;
            $repeat->fill($request->all());

            if(isset($request['flag_search_resource'])) {
                $resourceTemp  = \App\Resource::where('name', 'like', $booking->resource_id)->get();
                $booking->resource_id = $resourceTemp[0]->id;
            }
            
            //Resource Object
            $resourceOfBooking = \App\Resource::find($booking->resource_id);

            $booking->booking_date = date("Y-m-d G:i:s");
            $booking->registration_number = session('source_id');
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
            
            //TODO compleatare gestione invio email
//            mail($resourceOfBooking->room_admin_email, "TODO", "TODO");

            //Multiple event
            //TODO in sospeso : permettere l'inserimento di una singola prenotazione
            //o al max di prenotazioni all'interno di una settimana
            //Creare funzionalità di copia e incolla di una intera settimana ( per la segreteria )
            if($typeOfRepeat == 2) {

                $test = array();

                //data inizio ripetizione
                $repeat_start_string = substr($repeat->event_date_start, 0, 10)." 00:00";
                $repeat_start = date("d-m-Y G:i:s",strtotime($repeat_start_string));
                
                //data fine ripetizione
                $repeat_end_string = substr($repeat->event_date_end, 0, 10)." 23:59";
                $repeat_end = date("d-m-Y G:i:s",strtotime($repeat_end_string));
                
                $weekRepeats = $request['type_repeat'];
                $countWeekRepeats = count($weekRepeats);
                
                $flagDate = $repeat_start;
                Log::info('BookingController - inizio ripetizione ['.$flagDate.']');
                if($weekRepeats != null && $countWeekRepeats > 0) {

                    do {
                        $dayofweekStartEvent = date('w', strtotime($repeat_start));
                        
                        for($i = 0; $i < $countWeekRepeats; $i++) {

                            $newdate = strtotime ( $weekRepeats[$i].' day' , strtotime ( $repeat_start ) ) ; // facciamo l'operazione
                            $newdate = date ( 'd-m-Y G:i:s', $newdate ); //trasformiamo la data nel formato accettato dal db YYYY-MM-DD
                            $dayofweekRepeatTemp = date('w', strtotime($newdate));

                            if($dayofweekStartEvent <= $dayofweekRepeatTemp) {
                                if($newdate <= $repeat_end) {
                                    array_push($test, $newdate);
                                    $flagDate = $newdate;
                                    Log::info('BookingController - data intermedia ['.$flagDate.']');
                                }
                            }

                        }
                        
                        $dayofweekFlagDate = date('w', strtotime($flagDate));
                        Log::info('BookingController - Insert repeat ['.$dayofweekFlagDate.']');
                        do {
                           $flagDate = strtotime ( '1 day' , strtotime ($flagDate ) ) ;
                           $flagDate = date ( 'd-m-Y G:i:s', $flagDate );
                           $dayofweekFlagDate = date('w', strtotime($flagDate));
                           Log::info('BookingController - new interval ['.$flagDate.']');
                        } while($dayofweekFlagDate == 1);
                        
                        $repeat_start = strtotime ( '1 week' , strtotime ($repeat_start ) ) ;
                        $repeat_start = date ( 'd-m-Y G:i:s', $repeat_start );
                        
                    } while($flagDate <= $repeat_end);
                    
                }
                
                return view('pages/test/testInsert', ['testDate' => $test]);

            }
            
            return redirect()->route('bookings2', [$resourceOfBooking->group_id, $booking->resource_id])->with('success', 'booking_insert_ok');
            
        } catch(Exception $ex) {
            Log::error('BookingController - Errore nell\'inserimento della prenotazione: '.$ex->getMessage());
            return redirect()->back()->with('customError', 'booking_insert_ko');
        }
        
    }
    
    public function getListOfResourcesByIdGroup(Request $request) {
        
        $idGroup = $request['idGroup'];
        Log::info('BookingController - getListOfResourcesByIdGroup(idGroup: '.$idGroup.')');
        return \App\Resource::where('group_id', '=', $idGroup)->select('name as text', 'id')->get();
        
    }
    
    public function getSpecificResource(Request $request) {
        
        $idResource = $request['id_resource'];
        Log::info('BookingController - getSpecificResource(idResource: '.$idResource.')');
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

        return view('pages/booking/new-booking', [  'booking'      => $booking,
                                                    'groupsList'   => $groupsList,
                                                    'resourceList' => $resourceList,
                                                    'tipEventList' => $tipEventList,
                                                    'listOfTeachings' => $listOfTeachings]);
        
    }
    
    public function getNewBookingFormWithResource($idResource, $date_start, $date_end) {
        
        Log::info('BookingController - getNewBookingFormWithResource(idResource: '.$idResource.', date_start: '.$date_start.', date_end: '.$date_end.')');
    
        $booking = new \App\Booking;
        $resource =  \App\Resource::find($idResource);
        $group = \App\Group::find($resource->group_id);
        $tipEventList = \App\TipEvent::pluck('name', 'id');
        
        $listOfTeachings = "";
        if(session('ruolo') == 'docente') {
            $listOfTeachings = new \Illuminate\Support\Collection(session('listOfTeachings'));
        }

        return view('pages/booking/new-booking', [  'booking'         => $booking,
                                                    'group'           => $group,
                                                    'resource'        => $resource,
                                                    'tipEventList'    => $tipEventList,
                                                    'listOfTeachings' => $listOfTeachings,
                                                    'date_start'      => $date_start,
                                                    'date_end'        => $date_end]);
        
    }
    
    //Lista di tutte le prenotazioni per id group
    public function getBookingsByIdGroup($idGroup) {
        
        Log::info('BookingController - getBookingsByIdGroup(idGroup: '.$idGroup.')');
        
        $group = \App\Group::find($idGroup);
        $resources = $group->resources;
        $firstResource = $resources->first();
        $bookings = \App\Booking::where('resource_id', $firstResource->id)->get();
        $eventsType = \App\TipEvent::all();
        $bookingsStatus = \App\TipBookingStatus::all();
        
        return view('pages/booking/index-calendar', [   'selectedResource' => $firstResource,
                                                        'resources'    => $resources, 
                                                        'group'        => $group,
                                                        'eventsType'   => $eventsType,
                                                        'bookingsStatus'=> $bookingsStatus,
                                                        'bookings'     => $bookings]);
        
    }
    
    //Lista di tutte le prenotazioni per id group e id resource
    public function getBookingsByIdGroupIdResource($idGroup, $idResource) {
        
        Log::info('BookingController - getBookingsByIdGroupIdResource(idGroup: '.$idGroup.', idResource: '.$idResource.')');
        
        $group = \App\Group::find($idGroup);
        $resources = $group->resources;
        $resource = \App\Resource::find($idResource);
        $bookings = \App\Booking::where('resource_id', '=', $idResource)->get();
        $eventsType = \App\TipEvent::all();
        $bookingsStatus = \App\TipBookingStatus::all();
        
        return view('pages/booking/index-calendar', [   'bookings' => $bookings,
                                                        'selectedResource' => $resource,
                                                        'resources' => $resources,
                                                        'eventsType'   => $eventsType,
                                                        'bookingsStatus'=> $bookingsStatus,
                                                        'group' => $group]);
        
    }
    
    //metodo di test per l'update di una prenotazione tramite drug&drop o resize (disabilitato)
    //TODO se da utilizzare aggiornare campi viste le modifiche alle tabelle
    public function updateEvent(Request $request) {
        
        Log::info('BookingController - updateEvent()');
        
        $idEvent    = $request['id_evento'];
        $startEvent = $request['data_inizio'];
        $endEvent   = $request['data_fine'];
        
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
                'msg'    => 'A cannone',
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
