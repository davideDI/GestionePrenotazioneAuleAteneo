<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SearchController extends Controller {
    
    public function getSearchView() {
        
        Log::info('SearchController - getSearchView()');
        
        $groupList = \App\Group::all();
       
        return view('pages/search/search', ['groupsList' => $groupList]);
        
    }
    
    public function searchByCapacity(Request $request) {
        
        Log::info('SearchController - searchByCapacity()');
        
        $listOfGroups= $request['listOfGroups'];
        $capacity = $request['capacity'];
        if($capacity == '') {
            $capacity = 0;
        }
        
        $resourceList = \App\Resource::with('group')->whereIn('group_id', $listOfGroups)->where('capacity', '>=', $capacity)->get();

        return $resourceList;
        
    }
    
    //TODO ottimizzare query e cercare di utilizzare Eloquent
    public function searchByFree(Request $request) {
        
        Log::info('SearchController - searchByFree()');
        
        $listOfGroups = $request['listOfGroups'];
        $qMarks = str_repeat('?,', count($listOfGroups) - 1) . '?';
        
        $capacity = $request['capacity'];
        if($capacity == '') {
            $capacity = 0;
        }
        $date = $request['date_search'];
        $date_sring = date("Y-m-d",strtotime($date));
        $date_start = $request['date_start'].':00';
        $date_end = $request['date_end'].':00';
        $date_start_string = $date_sring.' '.$date_start;
        $date_end_string = $date_sring.' '.$date_end;
        $repeat_start = date("Y-m-d G:i:s",strtotime($date_start_string));
        $repeat_end = date("Y-m-d G:i:s",strtotime($date_end_string));
        
        $listOfParameters = array();
        
        array_push($listOfParameters, $capacity);
        for($i = 0; $i < count($listOfGroups); $i++) {
            array_push($listOfParameters, $listOfGroups[$i]);
        }
                
        array_push($listOfParameters, $capacity);
        for($i = 0; $i < count($listOfGroups); $i++) {
            array_push($listOfParameters, $listOfGroups[$i]);
        }
        
        
        array_push($listOfParameters, $repeat_start);
        array_push($listOfParameters, $repeat_end);
        array_push($listOfParameters, $repeat_start);
        array_push($listOfParameters, $repeat_end);
        
        Log::info($listOfParameters);
        
        $resourceList = DB::select
                        ( DB::raw
                            ("  
                                select 

                                    groups.name, 
                                    groups.id as id_group, 
                                    resources.name as name_resource, 
                                    resources.id as id_resources,
                                    resources.description as description_resource, 
                                    resources.room_admin_email, 
                                    resources.capacity  

                                from resources, groups

                                where 
                                    resources.group_id = groups.id
                                AND

                                    resources.capacity >= ?
                                and 

                                    groups.id in ({$qMarks})

                                and 

                                resources.id not in (

                                select distinct resources.id
                                from resources, groups, bookings, repeats
                                WHERE

                                resources.group_id = groups.id

                                AND

                                resources.capacity >= ?

                                and 

                                groups.id in ({$qMarks})

                                AND

                                bookings.resource_id = resources.id

                                AND

                                repeats.booking_id = bookings.id

                                AND
                                (
                                (repeats.event_date_start >= ? and repeats.event_date_start <= ?)
                                        or
                                (repeats.event_date_end >= ? and repeats.event_date_end <= ?))

                                    )
                            ")
                            , 
                            $listOfParameters
                        );
                                    
        return $resourceList;
        
    }
     
}

