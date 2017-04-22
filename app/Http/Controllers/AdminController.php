<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller {

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
                    //Se lo stato della prenotazione è RICHIESTA
                    if($booking->tip_booking_status_id == 1) {
                        array_push($quequedBookings, $booking);
                    }
                    //Se lo stato della prenotazione è RICHIESTA
                    if($booking->tip_booking_status_id == 2) {
                        array_push($workingBookings, $booking);
                    }
                    //Se lo stato della prenotazione è RICHIESTA
                    if($booking->tip_booking_status_id == 3) {
                        array_push($confirmedBookings, $booking);
                    }
                    //Se lo stato della prenotazione è RICHIESTA
                    if($booking->tip_booking_status_id == 4) {
                        array_push($rejectedBookings, $booking);
                    }
                }    
            }
        }
        
        return view('pages/console', [  'quequedBookings'   => $quequedBookings,
                                        'workingBookings'   => $workingBookings,
                                        'confirmedBookings' => $confirmedBookings,
                                        'rejectedBookings'  => $rejectedBookings,
                                        'groups'        => $groups]);
        
    }
    
    public function getBookingsByIdGroup() {
        
        Log::info('AdminController - getBookingsByIdGroup()');
        
        $idGroup = $_POST['id_group'];
        $group = \App\Group::find($idGroup);
        return $group;
        
    }
    
}
