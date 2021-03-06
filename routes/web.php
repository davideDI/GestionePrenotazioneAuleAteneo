<?php

/**************** HOME ******************************/
Route::get('/','HomeController@getHome')->name('home');

Route::post('/manage-badge', 'HomeController@manageBadge')->name('manage-badge');

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

Route::post('/download-pdf', 'PrintController@downloadPDF')->name('downloadPDF');

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
Route::get('/manage-user', 'AclController@getManageUserView')->name('manage-user');

Route::post('/get-ldap-user-info', 'AclController@getLdapUserInfo')->name('get-ldap-user-info');

Route::post('/insert-user', 'AclController@insertUser')->name('insert-user');

Route::get('/acl', 'AclController@getUsersList')->name('users-list');

Route::get('/acl/{idAcl}', 'AclController@updateAclView')->name('acl-update-view');

Route::post('/acl', 'AclController@updateAcl')->name('acl-update');

Route::delete('/acl', 'AclController@deleteAcl')->name('acl-delete');

/**************** BOOKING ******************************/
Route::post('/booking', 'BookingController@getBooking')->name('booking');

/* Visualizzazione prenotazioni in base a id group */
Route::get('/bookings/{idGroup}', 'BookingController@getBookingsByIdGroup')->name('bookings')->where('idGroup', '[0-9]+');

Route::post('/bookings', 'AdminController@getBookingsByIdGroup');

Route::post('/booking-repeat-events', 'BookingController@getBookingsForRepeatEvents');

Route::post('/booking-repeat-events-confirm', 'BookingController@confirmRepeatEvents');

/**************** REPEAT ******************************/
Route::get('/repeat/{idRepeat}', 'RepeatController@updateRepeatView');

Route::post('/update-repeat', 'RepeatController@updateRepeat');

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

Route::post('/cds', 'BookingController@getCDSFromDepartment');

Route::post('/subjects', 'BookingController@getSubjectsFromCDS');

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

/**************** LOGIN ******************************/
Route::get('/login', 'Auth\LoginController@getLoginView');

//Da file di configurazione impostare parametri di connessione
Route::post('/login', 'SoapController@login'); 

/**************** LOGOUT ******************************/
Route::get('/logout', 'SoapController@logout'); 


