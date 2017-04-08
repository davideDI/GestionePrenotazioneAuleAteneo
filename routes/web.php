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
});

/**************** BOOKING ******************************/
/* Visualizzazione eventi in base a id group */
Route::get('/bookings/{idGroup}', 'BookingController@getBookingsByIdGroup');

/* Visualizzazione eventi in base a id group e id resource */
Route::get('/bookings/{idGroup}/{idResource}', 'BookingController@getBookingsByIdGroupIdResource');

Route::get('/new-booking', function() {
    Log::info('web.php: get() [/new-booking]');
    $booking = new App\Booking;
    $groupsList = App\Group::pluck('name', 'id');
    $resourceList = App\Resource::pluck('name', 'id');
    return view('pages/new-booking', ['booking'      => $booking,
                                      'groupsList'   => $groupsList,
                                      'resourceList' => $resourceList]);
});

Route::post('/new-booking', function(\Illuminate\Http\Request $request) {
    Log::info('web.php: post() [/new-booking]');
    $booking = new App\Booking; 
    $booking->fill($request->all());
    return view('pages/test', ['booking' => $booking]);
});

/* Inserimento nuova prenotazione */
Route::post('/insert-booking', 'BookingController@createNewBooking');

/**************** CONSOLE ADMIN ******************************/
Route::get('/console', function () {
    Log::info('web.php: [/console]');
    return view('pages/console');
});

/**************** TEST ******************************/
/* Route di test update evento from drop */
Route::post('/updateEvent', 'BookingController@updateEvent'); 

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
Auth::routes();

Route::get('/home', 'HomeController@index');
