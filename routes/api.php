<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

/**************** ESPOSIZIONE SERVIZI ******************************/
Route::get('/v1/groups/{id?}', function($id = null) {

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
        'error'       => false,
        'result'      => $groupsList,
        'status_code' => 200
    ));
});

Route::get('/v1/resources/{id?}', function($id = null) {

    //se non viene inserito nessun id verrà ritornata tutta la lista di gruops
    if ($id == null) {
        $resourcesList = App\Resource::all(array('id', 'name', 'description'));
    } 
    //se l'id è presente la lista sarà filtrata per id
    else {
        $resourcesList = App\Resource::find($id, array('id', 'name', 'description'));
    }
    
    //Preparo il json di risposta
    return Response::json(array(
        'error'       => false,
        'result'      => $resourcesList,
        'status_code' => 200
    ));
});

/*
 * $date = 20170930
 */
Route::get('/v1/bookings/{date?}', function($date = null) {
   
    if($date == null) {
        $bookingList = App\Booking::with('repeats')->get();
    } else {
        $booking_date_start = date("Y-m-d G:i:s", strtotime($date." 00:00"));
        $booking_date_end = date("Y-m-d G:i:s", strtotime($date." 23:59"));
        
        $bookingList = App\Booking::with('repeats')
                ->whereHas('repeats', function($q) use ($booking_date_start, $booking_date_end) {
                    $q->where('event_date_start', '>=', $booking_date_start)
                      ->where('event_date_end', '<=', $booking_date_end);
                })
                ->get();
    }
    
    return Response::json(array(
        'error'       => false,
        'result'      => $bookingList,
        'status_code' => 200
    ));
    
});
