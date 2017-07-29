<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Repeat;
use App\TipBookingStatus;

include 'Variables.php';

class RepeatController extends Controller {
    
    public function updateRepeatView($idRepeat) {
        
        Log::info('RepeatController - updateRepeatView(idRepeat: '.$idRepeat.')');
        
        $repeat = Repeat::find($idRepeat);
        $repeat->event_date_start = date("d-m-Y G:i",strtotime($repeat->event_date_start));
        $repeat->event_date_end = date("d-m-Y G:i",strtotime($repeat->event_date_end));
        
        $listOfTipBookingStatus = TipBookingStatus::pluck('description', 'id');
        
        return view('pages/repeat/update-repeat', [ 'repeat'                 => $repeat, 
                                                    'listOfTipBookingStatus' => $listOfTipBookingStatus]);
        
    }
    
    public function updateRepeat(Request $request) {
        
        Log::info('RepeatController - updateRepeat()');
        
        $this->validate($request, [
            'event_date_start'       => 'required',
            'event_date_end'         => 'required',
            'tip_booking_status_id'  => 'required'
        ]);
        
        $repeat = Repeat::with('booking')->find($request->id);
        
        $repeat_start = date("Y-m-d G:i:s",strtotime($request['event_date_start'].":00"));
        $repeat->event_date_start = $repeat_start;
        
        $repeat_end = date("Y-m-d G:i:s",strtotime($request['event_date_end'].":00"));
        $repeat->event_date_end = $repeat_end;
        
        $repeat->tip_booking_status_id = $request['tip_booking_status_id'];
        
        $repeat->save();
        
        return redirect()->route('bookings', $repeat->booking->resource->group_id)->with('success', 'repeat_booking_update_ok');
        
    }
    
}

