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

/**************** MANAGE RESOURCES ******************************/
Route::get('/manage-resources', 'ResourceController@getResourceView')->name('manage_resources');

Route::get('/manage-resources/{idGroup}', 'ResourceController@getResourceFromId')->name('manage_resources_from_id')->where('idGroup', '[0-9]+');

Route::get('/insert-group', 'ResourceController@getInsertGroupView')->name('manage_resources_insert_resource');

Route::post('/insert-group', 'ResourceController@insertGroup');

Route::get('/insert-resource', 'ResourceController@getInsertResourceView')->name('manage_resources_insert_group');

Route::post('/insert-resource', 'ResourceController@insertResource');

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

Route::get('/new-booking', 'BookingController@getNewBookingForm')->name('newbooking-form');

/* Inserimento nuova prenotazione e reindirizzamento verso il calendario prenotazioni */
Route::post('/new-booking', 'BookingController@insertNewBooking');

function date_change_format($setDate, $from='d-m-Y', $to='Y-m-d') {
    if ($setDate != '') {
        $date = DateTime::createFromFormat($from, $setDate);
        return $date->format($to);
    } else {
        return '';
    }
}

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

/**************** TEST ******************************/
/* Route di test update evento from drop */
Route::post('/updateEvent', 'BookingController@updateEvent'); 

/**************** LOGIN ******************************/
/* Route di test per la chiamata al servizio login segreteria virtuale */
//Login Esse3
Route::post('/login', 'SoapController@wsLogin'); 
//Inserendo la matricola docente l'utente viene autenticato in modo fittizio e vengono inserite in sessione
//le info sulle properie materie
//TODO Autenticazione con LDAP
//Route::post('/login', 'SoapController@wsGetUdDocPart'); 

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
