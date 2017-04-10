<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {

    //Ricerca prenotazione in base a "Groups" amministrati
    public function getBookingByIdAdmin() {
        
        Log::info('AdminController - getBookingByIdAdmin()');
        
        $user = Auth::user();
        
        //Groups amministrati dall'utente
        $groups = \App\Group::where('admin_id', $user->id)->get();
   
        $bookings = array();
        //Per ogni gruppo
        foreach($groups as $group) {
            //Per ogni risorsa associata ad un gruppo
            foreach($group->resources as $resource) {
                //Per ogni prenotazione associata ad una risorsa
                foreach($resource->bookings as $booking) {
                    //Se lo stato della prenotazione è RICHIESTA
                    if($booking->tip_booking_status_id == 1) {
                        array_push($bookings, $booking);
                    }
                }    
            }
        }
        return view('pages/console', ['bookings' => $bookings]);
        
    }
    
}
