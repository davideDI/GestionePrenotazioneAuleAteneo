<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class SearchController extends Controller {
    
    public function getSearchView() {
        
        Log::info('SearchController - getSearchView()');
        
        $groupList = \App\Group::all();
       
        return view('pages/search/search', ['groupsList' => $groupList]);
        
    }
    
//     var dataInput = {
//                    
//                    'listOfGroups' : $("#listOfGroups").val(),
//                    'capacity'     : $("#capacity").val(),
//                    'datepicker'   : $("#datepicker").val(),
//                    'date_start'   : $("#date_start").val(),
//                    'date_end'     : $("#date_end").val(),
//                    
//                };
    
    public function searchByCapacity(Request $request) {
        
        Log::info('SearchController - searchByCapacity()');
        
        $listOfGroups= $request['listOfGroups'];
        $capacity = $request['capacity'];
        
        $resourceList = \App\Resource::with('group')->whereIn('group_id', $listOfGroups)->where('capacity', '>=', $capacity)->get();

        return $resourceList;
        
    }
    
    public function searchByFree(Request $request) {
        
        Log::info('SearchController - searchByFree()');
        
        $listOfGroups= $request['listOfGroups'];
        $date = $request['datepicker'];
        $date_start = $request['date_start'].'00:00';
        $date_end = $request['date_end'].'00:00';
        $capacity = $request['capacity'];
        
        $resourceList = \App\Resource::with('group')
                ->whereIn('group_id', $listOfGroups)
                ->where('capacity', '>=', $capacity)
                ->leftJoin('bookings', function($join){
                    $join ->on('resources.id', '=', 'bookings.resource_id');
                })
                ->leftJoin('repeats', function($join){
                    $join ->on('bookings.id', '=', 'repeats.booking_id');
                })
                ->where('event_date_start', '>=', $date.' '.$date_start)
                ->where('event_date_end', '<=',  $date.' '.$date_end)
                ->get();
                
        /*
         * 
select * from resources left join bookings on bookings.resource_id = resources.id left join repeats on bookings.id = repeats.booking_id

where 

resources.group_id in (1)

and 

resources.capacity >= 11

and

not (repeats.event_date_start >= '2017-06-08 11:00:00' and repeats.event_date_end <= '2017-06-08 13:00:00')
         */
        
        return $resourceList;
        
    }
    
}

