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

/* Pagine principale */
Route::get('/', function () {
    return view('layouts/pages/index');
});

Route::get('/tipevento', function () {
    
    $tipiEvento = App\TipEvent::all();
    return view('layouts/pages/tipevento', [ 'tipiEvento' => $tipiEvento ]); 
    
});
