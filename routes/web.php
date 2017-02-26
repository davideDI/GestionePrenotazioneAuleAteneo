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

/* Home */
Route::get('/', function () {
   
    //carico la lista di Groups per la selezione dell'utente
    $groupsList = App\Group::all();
    return view('pages/index', [ 'groupsList' => $groupsList ]);
    
});

Route::get('/home', 'HomeController@index');

/* Visualizzazione eventi in base a id group */
Route::get('/bookings/{idGroup}', 'BookingController@getEventByIdGroup');

/* Visualizzazione eventi in base a id group e id resource */
Route::get('/bookings/{idGroup}/{idResource}', 'BookingController@getEventByIdGroupIdResource');

/* TEST */
/* Inserimento nuova prenotazione */
Route::post('/insert-booking', 'BookingController@createNewBooking');

/* Route che gestisce il cambio di lingua */
Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);

/* Route utilizzata per l'autenticazione */
Auth::routes();

/* Route di test update evento from drop */
Route::post('/updateEvent', 'BookingController@updateEvent'); 



/* Test eposizione servizi rest */
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