<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller {

    //Search Bookings By Id Status
    public function getBookingsByIdStatus() {
    
        Log::info('AdminController - getBookingsByIdStatus()');
        
        $user_id = session('source_id');
        $idStatus = $_POST['id_status'];
        
        //Groups amministrati dall'utente
        $groups = \App\Group::where('admin_id', $user_id)->get();
        
        $bookingsList = array();
        
        //Per ogni gruppo
        foreach($groups as $group) {
            //Per ogni risorsa associata ad un gruppo
            foreach($group->resources as $resource) {
                //Per ogni prenotazione associata ad una risorsa
                foreach($resource->bookings as $booking) {
                    foreach($booking->repeats as $repeat) {
                        if($repeat->tip_booking_status_id == $idStatus) {
                            array_push($bookingsList, $booking);
                        }
                    }
                }    
            }
        }
        
        return $bookingsList;
        
    }
    
    //Ricerca prenotazione in base a "Groups" amministrati
    public function getBookings() {
        
        Log::info('AdminController - getBookings()');
        
        $user_id = session('source_id');
        
        $quequedBookings   = array();
        $workingBookings   = array();
        $confirmedBookings = array();
        $rejectedBookings  = array();
        
        //Groups amministrati dall'utente
        $groups = \App\Group::where('admin_id', $user_id)->get();
        
        //Per ogni gruppo
        foreach($groups as $group) {
            //Per ogni risorsa associata ad un gruppo
            foreach($group->resources as $resource) {
                //Per ogni prenotazione associata ad una risorsa
                foreach($resource->bookings as $booking) {
                    foreach($booking->repeats as $repeat) {
                        //Se lo stato della prenotazione è RICHIESTA
                        if($repeat->tip_booking_status_id == 1) {
                            array_push($quequedBookings, $booking);
                        }
                        //Se lo stato della prenotazione è IN LAVORAZIONE
                        if($repeat->tip_booking_status_id == 2) {
                            array_push($workingBookings, $booking);
                        }
                        //Se lo stato della prenotazione è GESTITA
                        if($repeat->tip_booking_status_id == 3) {
                            array_push($confirmedBookings, $booking);
                        }
                        //Se lo stato della prenotazione è SCARTATA
                        if($repeat->tip_booking_status_id == 4) {
                            array_push($rejectedBookings, $booking);
                        }
                    }
                }    
            }
        }
        
        return view('pages/console', [  'quequedBookings'   => $quequedBookings,
                                        'workingBookings'   => $workingBookings,
                                        'confirmedBookings' => $confirmedBookings,
                                        'rejectedBookings'  => $rejectedBookings,
                                        'groups'            => $groups]);
        
    }
    
    public function getBookingsByIdGroup() {
        
        Log::info('AdminController - getBookingsByIdGroup()');
        
        $bookings   = array();
        
        $idGroup = $_POST['id_group'];
        $group = \App\Group::find($idGroup);
        
        //Per ogni risorsa associata ad un gruppo
        foreach($group->resources as $resource) {
            //Per ogni prenotazione associata ad una risorsa
            foreach($resource->bookings as $booking) {
                $booking->resource_name = $booking->resource->name;
                foreach($booking->repeats as $repeat) {
                    //Stato RICHIESTA o IN LAVORAZIONE
                    if($repeat->tip_booking_status_id == 1 || $booking->tip_booking_status_id == 2) {
                        array_push($bookings, $booking);
                    }
                }
            }    
        }
        
        return $bookings;
        
    }
    
    public function confirmBooking() {
        
        $idRepeat = $_POST['id_repeat'];
        
        Log::info('AdminController - confirmBooking('.$idRepeat.')');
        
        $repeat = \App\Repeat::find($idRepeat);
        $repeat->tip_booking_status_id = 3;
        $repeat->save();
        
        return $repeat;
        
    }
    
    public function rejectBooking() {
        
        $idRepeat = $_POST['id_repeat'];
        
        Log::info('AdminController - rejectBooking('.$idRepeat.')');
        
        $repeat = \App\Repeat::find($idRepeat);
        $repeat->tip_booking_status_id = 4;
        $repeat->save();
        
        return $repeat;
        
    }
    
    public function test() {
        
        $bookings = \App\Booking::where('user_id', 1)->simplePaginate(3);
        
        return view('pages/test', [  'bookings'   => $bookings]);
        
    }
    
}
