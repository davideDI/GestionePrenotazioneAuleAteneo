<?php

use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

define('ERROR_MESSAGE_NO_MESSAGE', '');

define('ERROR_CODE_NONE', 'ERROR_CODE_NONE');
define('ERROR_CODE_INVALID_PARAMETER', 'ERROR_CODE_INVALID_PARAMETER');
define('ERROR_CODE_PDO_EXCEPTION', 'ERROR_CODE_PDO_EXCEPTION');
define('ERROR_CODE_EXCEPTION', 'ERROR_CODE_EXCEPTION');

/**************** UTILITY ******************************/
function getResponse($error, $errorCode, $errorMessage, $data, $statusCode) {
    
    return Response::json(array(
        'error'         => $error,
        'error_code'    => $errorCode,
        'error_message' => $errorMessage,
        'data'          => $data,
        'status_code'   => $statusCode
    ));
    
}

/**************** ESPOSIZIONE SERVIZI ******************************/

/**************** 1° LEVEL ******************************/
//List of groups
Route::get('/v1/groups', function() {

    Log::info('Api - /v1/groups');
    
    $groupsList = App\Group::all(array('name', 'description'));
    
    return getResponse(false, ERROR_CODE_NONE, ERROR_MESSAGE_NO_MESSAGE, $groupsList, 200);
    
});

//List of resources
Route::get('/v1/resources', function() {

    Log::info('Api - /v1/resources');
    
    $resourcesList = App\Resource::all(array('name', 'description'));
    
    return getResponse(false, ERROR_CODE_NONE, ERROR_MESSAGE_NO_MESSAGE, $resourcesList, 200);
    
});

//List of resources, with specific group
Route::get('/v1/group/{name}/resources', function($name = null) {

    Log::info('Api - /v1/group/'.$name.'/resources');
    
    if(is_numeric($name)) {
        
        return getResponse(true, ERROR_CODE_INVALID_PARAMETER, ERROR_MESSAGE_NO_MESSAGE, null, 400);

    }
    
    try {
        
        $resourcesList = App\Resource::with('group')
                                        ->whereHas('group', function($q) use ($name) {
                                            $q->where('name', 'like', '%'.$name.'%');
                                        })
                                        ->get();
        
    } catch (PDOException $pdoEx) {
        
        return getResponse(true, ERROR_CODE_PDO_EXCEPTION, $pdoEx->getMessage(), null, 400);
        
    } catch (Exception $ex) {
        
        return getResponse(true, ERROR_CODE_EXCEPTION, $ex->getMessage(), null, 400);
        
    }
    
    return getResponse(false, ERROR_CODE_NONE, ERROR_MESSAGE_NO_MESSAGE, $resourcesList, 200);
    
});

//List of teachers
Route::get('/v1/teachers', function() {

    Log::info('Api - /v1/teachers');
    
    try {
        
        $teachersList = App\User::where('tip_user_id', \App\TipUser::ROLE_TEACHER)
                                ->get(['cn', 'name', 'surname', 'email', 'registration_number']);
    
    } catch (PDOException $pdoEx) {
        
        return getResponse(true, ERROR_CODE_PDO_EXCEPTION, $pdoEx->getMessage(), null, 400);
        
    } catch (Exception $ex) {
        
        return getResponse(true, ERROR_CODE_EXCEPTION, $ex->getMessage(), null, 400);
        
    }
    
    return getResponse(false, ERROR_CODE_NONE, ERROR_MESSAGE_NO_MESSAGE, $teachersList, 200);
    
});
/**************** 1° LEVEL - END ******************************/

/**************** 2° LEVEL ******************************/


/**************** 2° LEVEL - END ******************************/

/**************** 3° LEVEL ******************************/


/**************** 3° LEVEL - END ******************************/


/*
 * $date = 20170930
 */
Route::get('/v1/bookings/{date?}', function($date = null) {
   //TODO validazione campi
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
        'data'        => $bookingList,
        'status_code' => 200
    ));
    
});
