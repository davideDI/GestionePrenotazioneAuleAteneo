<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/**************** HOME ******************************/
Route::get('/', function () {
   
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

/**************** BOOKING ******************************/
/* Visualizzazione eventi in base a id group */
Route::get('/bookings/{idGroup}', 'BookingController@getEventByIdGroup');

/* Visualizzazione eventi in base a id group e id resource */
Route::get('/bookings/{idGroup}/{idResource}', 'BookingController@getEventByIdGroupIdResource');

/**************** HELP ******************************/
Route::get('/help', function () {
    return view('pages/help');
});

/**************** REPORT ******************************/
Route::get('/report', function () {
    return view('pages/report');
});

/**************** PRINT ******************************/
Route::get('/print', function () {
    return view('pages/print');
});

/**************** SEARCH ******************************/
Route::get('/search', function () {
    return view('pages/search');
});

/**************** NEW EVENT ******************************/
Route::get('/insert-event', function() {
    return view('pages/new-event');
});

/**************** TEST ******************************/
/* Inserimento nuova prenotazione */
Route::post('/insert-booking', 'BookingController@createNewBooking');

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