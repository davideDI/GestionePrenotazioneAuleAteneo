<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Group;

class BookingController extends Controller {

    public function getGroupById($idGroup) {
        
        $bookings = DB::table('bookings')
            ->select('bookings.name as book_name', 'events.event_date_start as start_date', 'events.event_date_end as end_date')
            ->leftJoin('resources', 'bookings.id_resource', '=', 'resources.id')
            ->leftJoin('groups', 'resources.id_group', '=', 'groups.id')
            ->leftJoin('events', 'bookings.id_event', '=', 'events.id')
            ->where('groups.id', '=', $idGroup)
            ->get();
        
        $resources = DB::table('resources')
            ->select('resources.id', 'resources.name')
            ->leftJoin('groups', 'resources.id_group', '=', 'groups.id')
            ->where('groups.id', '=', $idGroup)
            ->get();
        
        $group = Group::find($idGroup);
        
        return view('pages/index-calendar', [ 'bookings' => $bookings,
                                              'resources' => $resources,
                                              'group' => $group]);
        
    }

}