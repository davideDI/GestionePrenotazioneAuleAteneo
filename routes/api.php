<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
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

define('ERROR_MESSAGE_NO_MESSAGE',          '');

define('ERROR_CODE_NONE',                   'ERROR_CODE_NONE');
define('ERROR_CODE_INVALID_PARAMETER',      'ERROR_CODE_INVALID_PARAMETER');
define('ERROR_CODE_PDO_EXCEPTION',          'ERROR_CODE_PDO_EXCEPTION');
define('ERROR_CODE_EXCEPTION',              'ERROR_CODE_EXCEPTION');
define('ERROR_CODE_INVALID_FORMAT',         'ERROR_CODE_INVALID_FORMAT');

define('FORMAT_JSON',                       'json');
define('FORMAT_TXT',                        'txt');
define('FORMAT_HTML',                       'html');
define('FORMAT_QR',                         'qr');

define('GOOGLE_API_GENERATOR_QR',           'https://chart.googleapis.com/chart?');
define('GOOGLE_API_PARAMETER_CHT',          'cht');
define('GOOGLE_API_PARAMETER_CHS',          'chs');
define('GOOGLE_API_PARAMETER_CHL',          'chl');
define('GOOGLE_API_PARAMETER_CHOE',         'choe');

define('GOOGLE_API_PARAMETER_VALUE_CHT',    'qr');
define('GOOGLE_API_PARAMETER_VALUE_CHOE',   'UTF-8');
define('GOOGLE_API_PARAMETER_VALUE_CHS',    '540x540');

/**************** UTILITY ******************************/
function getResponse($error, $errorCode, $errorMessage, $data, $statusCode) {
    
    if($error == true) {
        Log::error('Api: '.Request::url().'. Exception: '.$errorCode.'. Error Message: '.$errorMessage);
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

function getToday() {
    
    return date('Y-m-d');
    
}

function getSupportedFormat() {
    
    return array(FORMAT_JSON, FORMAT_HTML, FORMAT_TXT, FORMAT_QR);
    
}

function manageJsonToHtml($repeatsList) {
    
    $numOfElements = count($repeatsList);
    
    if($numOfElements == 0) {
        return 0;
    } else {
        $htmlResult = "<table>";
        $htmlResult .= "<tr><td>Name</td><td>Description</td><td>Event start</td><td>Event end</td><td>Materia</td><td>Risorsa</td><td>Gruppo</td></tr>";
        foreach ($repeatsList as $repeat) {
            $htmlResult .=  "<tr><td>"
                                .$repeat->booking->name.
                            "</td><td>"
                                .$repeat->booking->description.
                            "</td><td>"
                                .$repeat->event_date_start.
                            "</td><td>"
                                .$repeat->event_date_end.
                            "</td><td>"
                                .$repeat->booking->subject_id.
                            "</td><td>"
                                .$repeat->booking->resource->name.
                            "</td><td>"
                                .$repeat->booking->resource->group->name.
                            "</td></tr>";
        }
        $htmlResult .= "</table>";
        return $htmlResult;
    }
    
}  

function manageJsonToQr($url) {
    
    $newUrl = str_replace('/qr', '/html', $url);
    
    return  "<img src='".
            GOOGLE_API_GENERATOR_QR.
            GOOGLE_API_PARAMETER_CHS.'='.GOOGLE_API_PARAMETER_VALUE_CHS.'&'.
            GOOGLE_API_PARAMETER_CHT.'='.GOOGLE_API_PARAMETER_VALUE_CHT.'&'.
            GOOGLE_API_PARAMETER_CHL.'='.$newUrl.
            "'>";
    
}  

function manageJsonToTxt($repeatsList) {
    
    $numOfElements = count($repeatsList);
    
    if($numOfElements == 0) {
        return 0;
    } else {
        $txtResult = "";
        foreach ($repeatsList as $repeat) {
            $txtResult .=  $repeat->booking->name.' '.$repeat->booking->description.' '.$repeat->event_date_start.' '.
                           $repeat->event_date_end.' '.$repeat->booking->subject_id.' '.$repeat->booking->resource->name.' '.
                           $repeat->booking->resource->group->name.PHP_EOL;
        }
        return $txtResult;
    }
    
}  

/**************** API - v1 ******************************/

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
http://GestionePrenotazioneAuleAteneo/public/api/v1/group/{name}/resources -> list of resources by group
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
        
        $resourcesList = Resource::with('group')
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
 
http://GestionePrenotazioneAuleAteneo/public/api/v1/filter/{filter}/{group?}  -> list of repeats

WHERE
{filter} -> Mandatory. String. The name of a specific teacher or the description of an event
{group}  -> Optional. String. The name of a specific group

The list of results are ordered by date_start, from the current date.

*/

//List of repeats
Route::get('/v1/filter/{filter}/{group?}', function($filter = null, $group = null) {
   
    Log::info('Api - /v1/filter/'.$filter.'/'.$group);
    
    if(is_numeric($filter)) {
        
        return getResponse(true, ERROR_CODE_INVALID_PARAMETER, ERROR_MESSAGE_NO_MESSAGE, null, 400);

    }
    
    if($group != null && is_numeric($group)) {
        
        return getResponse(true, ERROR_CODE_INVALID_PARAMETER, ERROR_MESSAGE_NO_MESSAGE, null, 400);

    }
    
    try {
    
        $repeatsList = Repeat::with('booking', 'booking.user', 'booking.resource', 'booking.resource.group')
                            ->where('event_date_start', '>=', getToday())
                            
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

/*
|--------------------------------------------------------------------------
| 3° LEVEL 
|--------------------------------------------------------------------------
 
http://GestionePrenotazioneAuleAteneo/public/api/v1/repeats/resource/{resource}/{format?}                -> list of repeats of a specific resource
http://GestionePrenotazioneAuleAteneo/public/api/v1/repeats/group/{group}/resource/{resource}/{format?}  -> list of repeats of a specific resource

WHERE
{resource} -> Mandatory. String. The name of a specific resource.
{group}    -> Mandatory. String. The name of a specific group.
{format}   -> Optional. String. The specific type of return. Possible values [json | html | txt | qr]

The list of results are ordered by date_start, from the current date.

*/

Route::get('/v1/repeats/resource/{resource}/{format?}', function($resource = null, $format = null) {
    
    Log::info('Api - /v1/repeats/resource/'.$resource.'/'.$format);
        
    if($format != null && !in_array($format, getSupportedFormat())) {
        
        return getResponse(true, ERROR_CODE_INVALID_FORMAT, ERROR_MESSAGE_NO_MESSAGE, null, 400);
        
    }
    
    try {
    
        $repeatsList = Repeat::with('booking', 'booking.user', 'booking.resource', 'booking.resource.group')
                            ->where('event_date_start', '>=', getToday())
                            
                            ->whereHas('booking.resource', function($filterResource) use ($resource) {
                                $filterResource->where('name', 'like', '%'.$resource.'%');
                            })
                            
                            ->orderBy('event_date_start', 'ASC')
                            ->get();
                            
        if($format != null) {
            
            switch ($format) {
                case FORMAT_JSON:
                    return getResponse(false, ERROR_CODE_NONE, ERROR_MESSAGE_NO_MESSAGE, $repeatsList, 200);
            
                case FORMAT_HTML:
                    return manageJsonToHtml($repeatsList);

                case FORMAT_QR:
                    return manageJsonToQr(Request::url());

                case FORMAT_TXT:
                    return manageJsonToTxt($repeatsList);
            
            }
            
        }
        
        return getResponse(false, ERROR_CODE_NONE, ERROR_MESSAGE_NO_MESSAGE, $repeatsList, 200);
    
    } catch (PDOException $pdoEx) {
        
        return getResponse(true, ERROR_CODE_PDO_EXCEPTION, $pdoEx->getMessage(), null, 400);
        
    } catch (Exception $ex) {
        
        return getResponse(true, ERROR_CODE_EXCEPTION, $ex->getMessage(), null, 400);
        
    }
    
});

Route::get('/v1/repeats/group/{group}/resource/{resource}/{format?}', function($group = null, $resource = null, $format = null) {
    
    Log::info('Api - /v1/repeats/group/'.$group.'/resource/'.$resource.'/'.$format);
    
    if(is_numeric($group)) {
        
        return getResponse(true, ERROR_CODE_INVALID_PARAMETER, ERROR_MESSAGE_NO_MESSAGE, null, 400);
        
    }
    
    if($format != null && !in_array($format, getSupportedFormat())) {
        
        return getResponse(true, ERROR_CODE_INVALID_FORMAT, ERROR_MESSAGE_NO_MESSAGE, null, 400);
        
    }
    
    try {
    
        $repeatsList = Repeat::with('booking', 'booking.user', 'booking.resource', 'booking.resource.group')
                            ->where('event_date_start', '>=', getToday())
                            
                            ->whereHas('booking.resource', function($filterResource) use ($resource) {
                                $filterResource->where('name', 'like', '%'.$resource.'%');
                            })
                            
                            ->whereHas('booking.resource.group', function($filterGroup) use ($group) {
                                $filterGroup->where('name', 'like', '%'.$group.'%');
                            })
                            
                            ->orderBy('event_date_start', 'ASC')
                            ->get();
    
        if($format != null) {
            
            switch ($format) {
                case FORMAT_JSON:
                    return getResponse(false, ERROR_CODE_NONE, ERROR_MESSAGE_NO_MESSAGE, $repeatsList, 200);
            
                case FORMAT_HTML:
                    return manageJsonToHtml($repeatsList);

                case FORMAT_QR:
                    return manageJsonToQr(Request::url());

                case FORMAT_TXT:
                    return manageJsonToTxt($repeatsList);
            
            }
            
        }
        
        return getResponse(false, ERROR_CODE_NONE, ERROR_MESSAGE_NO_MESSAGE, $repeatsList, 200);
        
    } catch (PDOException $pdoEx) {
        
        return getResponse(true, ERROR_CODE_PDO_EXCEPTION, $pdoEx->getMessage(), null, 400);
        
    } catch (Exception $ex) {
        
        return getResponse(true, ERROR_CODE_EXCEPTION, $ex->getMessage(), null, 400);
        
    }
    
});

/**************** 3° LEVEL - END ******************************/
