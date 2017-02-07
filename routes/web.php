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

/* Route di test */
Route::get('/tipevento', function () {
    
    $tipiEvento = App\TipEvent::all();
    return view('pages/tipevento', [ 'tipiEvento' => $tipiEvento ]); 
    
});

/* Route di test visualizzazione calendario */
Route::get('/calendar', function () {
    
    return view('pages/index-calendar'); 
    
});

/* Route che gestisce il cambio di lingua */
Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);

Auth::routes();

Route::get('/home', 'HomeController@index');
