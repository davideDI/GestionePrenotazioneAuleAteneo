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
        $listOfGroupsArray = '';

        if($listOfGroups != null && count($listOfGroups) > 0) {
            foreach ($listOfGroups as $key => $value) {
                $listOfGroupsArray += $value.',';
            }
        }
        
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
               
        $resourceList = DB::select
                        ( DB::raw
                            ("  select resources.id, resources.name as name_resource, resources.description, resources.capacity, resources.room_admin_email,  groups.name
                                from 
                                    resources 
                                left join groups on groups.id = resources.group_id 
                                left join bookings on bookings.resource_id = resources.id 
                                left join repeats on bookings.id = repeats.booking_id
                                where 
                                    resources.group_id in (:idGroupList)
                                and 
                                    resources.capacity >= :capacity
                                and 
                                    not 
                                    
                                    (
                                        (repeats.event_date_start > :date_start and repeats.event_date_start < :date_end)
                                            ||
                                        (repeats.event_date_end > :date_start1 and repeats.event_date_end < :date_end1)
                                    )

                                    ")
                                    
                                    , 
                                array(
                                    'idGroupList' => $listOfGroupsArray,
                                    'capacity'    => $capacity,
                                    'date_start'  => $repeat_start,
                                    'date_end'    => $repeat_end,
                                     'date_start1'  => $repeat_start,
                                    'date_end1'    => $repeat_end,
                            ));
        
        return $resourceList;
        
    }
    
}

