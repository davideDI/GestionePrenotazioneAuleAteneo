<?php

use Illuminate\Support\Facades\Log;
use App\Group;
use App\Resource;
use App\User;
use App\TipUser;
use App\Repeat;

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
    
    if($error == true) {
        Log::error('Api: '.Route::current()->getUri().'. Exception: '.$errorCode.'. Error Message: '.$errorMessage);
    }
    
    return Response::json(array(
        'error'         => $error,
        'error_code'    => $errorCode,
        'error_message' => $errorMessage,
        'data'          => $data,
        'status_code'   => $statusCode
    ));
    
}

function getDateWeekStart() {
    
    $day = date('w');
    $week_start = date('Y-m-d G:i:s', strtotime('-'.$day.' days'));
    return $week_start;
    
}

function getDateWeekEnd() {
    
    $day = date('w');
    $week_end = date('Y-m-d G:i:s', strtotime('+'.(6-$day).' days'));
    return $week_end;
    
}

/**************** ESPOSIZIONE SERVIZI ******************************/

/*
|--------------------------------------------------------------------------
| RESPONSE - Json 
|--------------------------------------------------------------------------
    
    Example of an OK response
    {
        "error": false,
        "error_code": "ERROR_CODE_NONE",
        "error_message": "",
        "data": [
                    {...},
                    {...},
                ],
        "status_code": 200
    }
  
    Example of a KO response
    {
        "error": true,
        "error_code": "ERROR_CODE_PDO_EXCEPTION",
        "error_message": "SQLSTATE[42S22]: Column not found: 1054 Unknown column 'group.name' in 'where clause'",
        "data": [],
        "status_code": 400
    }
 */

/*
|--------------------------------------------------------------------------
| 1° LEVEL 
|--------------------------------------------------------------------------
 
http://GestionePrenotazioneAuleAteneo/public/api/v1/groups                  -> list of groups
http://GestionePrenotazioneAuleAteneo/public/api/v1/resources               -> list of resources
http://GestionePrenotazioneAuleAteneo/public/api//v1/group/{name}/resources -> list of resources by group
http://GestionePrenotazioneAuleAteneo/public/api/v1/teachers                -> list of teachers

WHERE
{name} -> Mandatory. String. Name of a specific group, selected from the list of groups of the first Api. 

*/

//List of groups
Route::get('/v1/groups', function() {

    Log::info('Api - /v1/groups');
    
    $groupsList = Group::all(array('name', 'description'));
    
    return getResponse(false, ERROR_CODE_NONE, ERROR_MESSAGE_NO_MESSAGE, $groupsList, 200);
    
});

//List of resources
Route::get('/v1/resources', function() {

    Log::info('Api - /v1/resources');
    
    $resourcesList = Resource::all(array('name', 'description'));
    
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
        
        $teachersList = User::where('tip_user_id', TipUser::ROLE_TEACHER)
                                ->get(['cn', 'name', 'surname', 'email', 'registration_number']);
    
    } catch (PDOException $pdoEx) {
        
        return getResponse(true, ERROR_CODE_PDO_EXCEPTION, $pdoEx->getMessage(), null, 400);
        
    } catch (Exception $ex) {
        
        return getResponse(true, ERROR_CODE_EXCEPTION, $ex->getMessage(), null, 400);
        
    }
    
    return getResponse(false, ERROR_CODE_NONE, ERROR_MESSAGE_NO_MESSAGE, $teachersList, 200);
    
});
/**************** 1° LEVEL - END ******************************/

/*
|--------------------------------------------------------------------------
| 2° LEVEL 
|--------------------------------------------------------------------------
 
http://GestionePrenotazioneAuleAteneo/public/api/v1/repeats/{filter}/{group?}  -> list of repeats

WHERE
{filter} -> Mandatory. String. The name of a specific teacher or the description of an event
{group}  -> Optional. String. The name of a specific group

The list of results are ordered by date_start, from the current date.

*/

//List of repeats
Route::get('/v1/repeats/{filter}/{group?}', function($filter = null, $group = null) {
   
    Log::info('Api - /v1/repeats/'.$filter.'/'.$group);
    
    if(is_numeric($filter)) {
        
        return getResponse(true, ERROR_CODE_INVALID_PARAMETER, ERROR_MESSAGE_NO_MESSAGE, null, 400);

    }
    
    if($group != null && is_numeric($group)) {
        
        return getResponse(true, ERROR_CODE_INVALID_PARAMETER, ERROR_MESSAGE_NO_MESSAGE, null, 400);

    }
    
    try {
    
        $repeatsList = Repeat::with('booking', 'booking.user', 'booking.resource', 'booking.resource.group')
                            ->where('event_date_start', '>=', getDateWeekStart())
                            
                            ->where(function($filterUserOrDescription) use($filter) {
                                $filterUserOrDescription->whereHas('booking.user', function($filterUser) use ($filter) {
                                                            $filterUser->where('name', 'like', '%'.$filter.'%')
                                                                       ->orWhere('surname', 'like', '%'.$filter.'%');
                                                        })
                                                        ->orWhereHas('booking', function($filterDescription) use ($filter) {
                                                            $filterDescription->where('description', 'like', '%'.$filter.'%');
                                                        });
                            })    
                            
                            ->whereHas('booking.resource.group', function($filterGroup) use ($group) {
                                if($group != null && $group != '') {
                                    $filterGroup->where('name', 'like', '%'.$group.'%');
                                }
                            })
                            
                            ->orderBy('event_date_start', 'ASC')
                            ->get();
    
    } catch (PDOException $pdoEx) {
        
        return getResponse(true, ERROR_CODE_PDO_EXCEPTION, $pdoEx->getMessage(), null, 400);
        
    } catch (Exception $ex) {
        
        return getResponse(true, ERROR_CODE_EXCEPTION, $ex->getMessage(), null, 400);
        
    }
    
    return getResponse(false, ERROR_CODE_NONE, ERROR_MESSAGE_NO_MESSAGE, $repeatsList, 200);
    
});

/**************** 2° LEVEL - END ******************************/

/**************** 3° LEVEL ******************************/


/**************** 3° LEVEL - END ******************************/
/*
 * ROOM: Search for events/lessons in a specific classroom: (Priority Level 3°)
This request may be performed with the "room" or "r" parameter having one of the following syntax:
http://aule.linfcop.univaq.it/api/index.php?[ room | r ]=<Classroom Name>
http://aule.linfcop.univaq.it/api/index.php?[ room | r ]=<Classroom Name> & [ s | structure ]=<Valid Structure Name>
http://aule.linfcop.univaq.it/api/index.php?[ room | r ]=<Classroom Name> & ... & [ n | number ]=<Integer Value>
http://aule.linfcop.univaq.it/api/index.php?[ room | r ]=<Classroom Name> & ... & like=[ false | true ]
http://aule.linfcop.univaq.it/api/index.php?[ room | r ]=<Classroom Name> & ... & [ f | format ]=[ json | html | txt | qr]
 */

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
        
        $bookingList = App\Booking::with('repeats', 'user')
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
