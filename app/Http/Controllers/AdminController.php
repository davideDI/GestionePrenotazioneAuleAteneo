<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Booking;

class AdminController extends Controller {

    //Ricerca prenotazione in base a "Groups" amministrati
    public function getBookingByIdAdmin() {
        
        Log::info('AdminController - getBookingByIdAdmin()');
        
        $user = Auth::user();
        $bookings = Booking::where('user_id', '=', $user->id);
        
        return view('pages/console', ['bookings' => $bookings]);
        
    }
    
}
