<?php

/**************** HOME ******************************/
Route::get('/', function () {
   
    Log::info('web.php: [/]');
    
    Session::set('applocale', Config::get('app.locale'));
    
    //carico la lista di Groups per la selezione dell'utente
    $groupsList = App\Group::all();
    return view('pages/index', [ 'groupsList' => $groupsList ]);
    
});

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
Route::get('/bookings/{idGroup}/{messageCode?}', 'BookingController@getBookingsByIdGroup')->name('bookings')->where('idGroup', '[0-9]+');

/* Visualizzazione prenotazioni in base a id group e id resource */
Route::get('/bookings/{idGroup}/{idResource}', 'BookingController@getBookingsByIdGroupIdResource')->where(['idGroup' => '[0-9]+', 'idResource' => '[0-9]+']);

Route::get('/new-booking/{messageCode?}', function($messageCode = null) {
    
    Log::info('web.php: get() [/new-booking]');
    
    $booking = new App\Booking;
    $groupsList = App\Group::pluck('name', 'id');
    $resourceList = App\Resource::pluck('name', 'id');
    $tipEventList = App\TipEvent::pluck('name', 'id');
    
    return view('pages/new-booking', ['booking'      => $booking,
                                      'groupsList'   => $groupsList,
                                      'resourceList' => $resourceList,
                                      'tipEventList' => $tipEventList,
                                      'messageCode'  => $messageCode]);
})->name('newbooking-form');

/* Inserimento nuova prenotazione e reindirizzamento verso il calendario prenotazioni */
Route::post('/new-booking', function(\Illuminate\Http\Request $request) {
    
    Log::info('web.php: post() [/new-booking]');
    
    //Recupero la risorsa selezioneta per la redirect()
    $booking = new App\Booking; 
    $booking->fill($request->all());
    $resourceOfBooking = App\Resource::find($booking->resource_id);
    
    try {
        Log::info('web.php: [/new-booking] - Inserimento prenotazione ['.$booking.']');
        //Di default viene inserita la data di sistema
        $booking->booking_date = date("Y-m-d G:i:s");
        $booking->user_id = Auth::user()->id;
        //Quando viene effettuata una prenotazione lo stato viene settato su "RICHIESTA"
        $booking->tip_booking_status_id = 1;
        //TODO
        //Sviluppare validazione campi
        $booking->save();
        return redirect()->route('bookings', ['idGroup'     => $resourceOfBooking->group_id,
                                              'messageCode' => 100]);
    } catch(Exception $ex) {
        Log::error('web.php: [/new-booking] - errore nell\'inserimento della prenotazione '.$ex->getMessage());
        return redirect()->route('newbooking-form', ['messageCode' => 500]);
    }
    
});

/**************** CONSOLE ADMIN ******************************/
//Ricerca prenotazione in base a "Groups" amministrati
Route::get('/console', 'AdminController@getBookingByIdAdmin');

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
