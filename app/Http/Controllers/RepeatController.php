<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class RepeatController extends Controller {
    
    public function updateRepeatView($idRepeat) {
        
        Log::info('RepeatController - updateRepeatView(idRepeat: '.$idRepeat.')');
        
        $repeat = \App\Repeat::find($idRepeat);
        $listOfTipBookingStatus = \App\TipBookingStatus::pluck('description', 'id');
        
        return view('pages/repeat/update-repeat', ['repeat' => $repeat, 'listOfTipBookingStatus' => $listOfTipBookingStatus]);
        
    }
    
    public function updateRepeat(Request $request) {
        
        Log::info('RepeatController - updateRepeat()');
        
        $this->validate($request, [
            'event_date_start'       => 'required',
            'event_date_end'         => 'required',
            'tip_booking_status_id'  => 'required'
        ]);
        
        $repeat = \App\Repeat::find($request->id);
        $repeat->fill($request->all());
        //TODO compleatare modifica evento
        //$repeat->save();
        
        return redirect()->route('home')->with('success', 'repeat_booking_update_ok');
        
    }
    
}

