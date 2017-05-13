<?php

/**************** HOME ******************************/
Route::get('/', function () {
   
    Log::info('web.php: [/]');
    
    Session::set('applocale', Config::get('app.locale'));
    
    //carico la lista di Groups per la selezione dell'utente
    $groupsList = App\Group::all();
    return view('pages/index', [ 'groupsList' => $groupsList ]);
    
})->name('home');

/**************** LANG ******************************/
/* Route che gestisce il cambio di lingua */
Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);

/**************** AUTH ******************************/
/* Route utilizzata per l'autenticazione */
Auth::routes();

/**************** HELP ******************************/
Route::get('/help', function () {
    Log::info('web.php: [/help]');
    return view('pages/help');
});

/**************** REPORT ******************************/
Route::get('/report', function () {
    Log::info('web.php: [/report]');
    return view('pages/report');
});

/**************** PRINT ******************************/
Route::get('/print', function () {
    Log::info('web.php: [/print]');
    return view('pages/print');
});

/**************** SEARCH ******************************/
Route::get('/search', function () {
    Log::info('web.php: [/search]');
    return view('pages/search');
})->name('search');

/**************** BOOKING ******************************/
/* Visualizzazione prenotazioni in base a id group */
Route::get('/bookings/{idGroup}', 'BookingController@getBookingsByIdGroup')->name('bookings')->where('idGroup', '[0-9]+');

Route::post('/bookings', 'AdminController@getBookingsByIdGroup');

Route::get('/test', 'AdminController@test');

/* Visualizzazione prenotazioni in base a id group e id resource */
Route::get('/bookings/{idGroup}/{idResource}', 'BookingController@getBookingsByIdGroupIdResource')->name('bookings2')->where(['idGroup' => '[0-9]+', 'idResource' => '[0-9]+']);

Route::get('/new-booking', function() {
    
    Log::info('web.php: get() [/new-booking]');
    
    $booking = new App\Booking;
    $groupsList = App\Group::pluck('name', 'id');
    $resourceList =  App\Resource::pluck('name', 'id');
    $tipEventList = App\TipEvent::pluck('name', 'id');
    
    return view('pages/new-booking', ['booking'      => $booking,
                                      'groupsList'   => $groupsList,
                                      'resourceList' => $resourceList,
                                      'tipEventList' => $tipEventList]);
})->name('newbooking-form');

/* Inserimento nuova prenotazione e reindirizzamento verso il calendario prenotazioni */
Route::post('/new-booking', function(\Illuminate\Http\Request $request) {
    
    date_default_timezone_set('Europe/Rome');
    
    //TODO
    //Sviluppare validazione campi
    
    Log::info('web.php: post() [/new-booking]');
    
    try {
    
        //Booking Object
        $booking = new App\Booking; 
        $booking->fill($request->all());

        //Repeat Object
        $repeat = new App\Repeat;
        $repeat->fill($request->all());

        //Resource Object
        $resourceOfBooking = App\Resource::find($booking->resource_id);
        
        $booking->booking_date = date("Y-m-d G:i:s");
        $booking->user_id = session('source_id');
        Log::info('web.php: [/new-booking] - Insert booking ['.$booking.']');
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
            Log::info('web.php: [/new-booking] - Insert repeat ['.$repeat.']');
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
        Log::error('web.php: [/new-booking] - errore nell\'inserimento della prenotazione '.$ex->getMessage());
        return Redirect::back()->withErrors([500]);
    }
    
});

function date_change_format($setDate, $from='d-m-Y', $to='Y-m-d') {
    if ($setDate != '') {
        $date = DateTime::createFromFormat($from, $setDate);
        return $date->format($to);
    } else {
        return '';
    }
}

Route::post('/resource', function() {
    
    $idResource = $_POST['id_resource'];
    return \App\Resource::find($idResource);
    
});

Route::post('/resources', function() {
    
    $idGroup = $_POST['idGroup'];
    return \App\Resource::where('group_id', '=', $idGroup)->select('name as text', 'id')->get();
    
});

/**************** CONSOLE ADMIN ******************************/
//Ricerca prenotazione in base a "Groups" amministrati
Route::get('/console', 'AdminController@getBookings');

//Ricerca prenotazione in base a stato prenotazione e admin autenticato
Route::post('/search-bookings-by-status', 'AdminController@getBookingsByIdStatus');

//Booking to "gestita" 
Route::post('/confirm-booking', 'AdminController@confirmBooking');

//Booking to "scartata" 
Route::post('/reject-booking', 'AdminController@rejectBooking');

/**************** TEST ******************************/
/* Route di test update evento from drop */
Route::post('/updateEvent', 'BookingController@updateEvent'); 

/**************** LOGIN ******************************/
/* Route di test per la chiamata al servizio login segreteria virtuale */
Route::post('/login', 'SoapController@wsLogin'); 

/**************** LOGOUT ******************************/
Route::get('/logout', 'SoapController@wsLogout'); 


/**************** TEST ESPOSIZIONE SERVIZI ******************************/
// API routes
// Test esposizione servizio lista di groups in base ad id
Route::get('/api/v1/groups/{id?}', ['middleware' => 'auth.basic', function($id = null) {

    //se non viene inserito nessun id verrà ritornata tutta la lista di gruops
    if ($id == null) {
        $groupsList = App\Group::all(array('id', 'name', 'description'));
    } 
    //se l'id è presente la lista sarà filtrata per id
    else {
        $groupsList = App\Group::find($id, array('id', 'name', 'description'));
    }
    
    //Preparo il json di risposta
    return Response::json(array(
                'error' => false,
                'products' => $groupsList,
                'status_code' => 200
            ));
}]);
