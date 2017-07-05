<?php

/**************** HOME ******************************/
Route::get('/','HomeController@getHome')->name('home');

/**************** LANG ******************************/
/* Route che gestisce il cambio di lingua */
Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);

/**************** AUTH ******************************/
/* Route utilizzata per l'autenticazione */
Auth::routes();

/**************** HELP ******************************/
Route::get('/help', 'HelpController@getHelpView')->name('helpView');

/**************** REPORT ******************************/
Route::get('/report', 'ReportController@getReportView')->name('reportView');

/**************** PRINT ******************************/
Route::get('/print', 'PrintController@getPrintView')->name('printView');

/**************** SEARCH ******************************/
Route::get('/search', 'SearchController@getSearchView')->name('search');

Route::post('/search-by-capacity', 'SearchController@searchByCapacity')->name('searchByCapacity');

Route::post('/search-by-free', 'SearchController@searchByFree')->name('searchByFree');

/**************** MANAGE RESOURCES ******************************/
Route::get('/manage-resources', 'ResourceController@getResourceView')->name('manage_resources');

Route::get('/manage-resources/{idGroup}', 'ResourceController@getResourceFromId')->name('manage_resources_from_id')->where('idGroup', '[0-9]+');

Route::get('/insert-group', 'ResourceController@getInsertGroupView')->name('manage_resources_insert_resource');

Route::post('/insert-group', 'ResourceController@insertGroup');

Route::get('/group/{idGroup}', 'ResourceController@updateGroupView');

Route::post('/update-group', 'ResourceController@updateGroup');

Route::delete('/group/{idGroup}', 'ResourceController@deleteGroup');

Route::get('/insert-resource', 'ResourceController@getInsertResourceView')->name('manage_resources_insert_group');

Route::post('/insert-resource', 'ResourceController@insertResource');

Route::get('/resource/{idResource}', 'ResourceController@updateResourceView')->name('update-resource')->where('idGroup', '[0-9]+');

Route::post('/update-resource', 'ResourceController@updateResource');

Route::delete('/resource/{idResource}', 'ResourceController@deleteResource');

/**************** ACL ******************************/
Route::get('/acl', 'AclController@getAclView')->name('acl');

/**************** BOOKING ******************************/
Route::post('/booking', 'BookingController@getBooking')->name('booking');

/* Visualizzazione prenotazioni in base a id group */
Route::get('/bookings/{idGroup}', 'BookingController@getBookingsByIdGroup')->name('bookings')->where('idGroup', '[0-9]+');

Route::post('/bookings', 'AdminController@getBookingsByIdGroup');

Route::get('/test', 'AdminController@test');

/* Visualizzazione prenotazioni in base a id group e id resource */
Route::get('/bookings/{idGroup}/{idResource}', 'BookingController@getBookingsByIdGroupIdResource')->name('bookings2')->where(['idGroup' => '[0-9]+', 'idResource' => '[0-9]+']);

Route::get('/new-booking/{idResource?}/{date_start?}/{date_end?}', function($idResource = null, $date_start = null, $date_end = null) {
    
    if($idResource == null && $date_start == null && $date_end == null) {
        return App::make('\App\Http\Controllers\BookingController')->getNewBookingForm();
    } else {
        return App::make('\App\Http\Controllers\BookingController')->getNewBookingFormWithResource($idResource, $date_start, $date_end);
    }
    
});

/* Inserimento nuova prenotazione e reindirizzamento verso il calendario prenotazioni */
Route::post('/new-booking', 'BookingController@insertNewBooking');

Route::post('/resource', 'BookingController@getSpecificResource');

Route::post('/resources', 'BookingController@getListOfResourcesByIdGroup');

/**************** CONSOLE ADMIN ******************************/
//Ricerca prenotazione in base a "Groups" amministrati
Route::get('/console', 'AdminController@getBookings');

//Ricerca prenotazione in base a stato prenotazione e admin autenticato
Route::post('/search-bookings-by-status', 'AdminController@getBookingsByIdStatus');

//Booking to "gestita" 
Route::post('/confirm-booking', 'AdminController@confirmBooking');

//Booking to "scartata" 
Route::post('/reject-booking', 'AdminController@rejectBooking');

/**************** CHECKS ******************************/
Route::get('/checks', 'CheckController@getChecksView')->name('checks');

Route::post('/check', 'CheckController@updateCheck')->name('updateCheck');

Route::post('/insert-request-check', 'CheckController@insertRequestCheck');

/**************** TEST ******************************/
/* Route di test update evento from drop */
Route::post('/updateEvent', 'BookingController@updateEvent'); 

/**************** LOGIN ******************************/
Route::get('/login', 'Auth\LoginController@getLoginView');

//TODO Autenticazione con LDAP
//A seconda della username inserita viene effettuata un autenticazione fittizia
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
