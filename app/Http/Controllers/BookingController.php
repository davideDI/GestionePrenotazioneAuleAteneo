<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


class BookingController extends Controller {

    //switch language
    public function getGroupById($idGroup) {
        
        return view('pages/index-calendar', [ 'group' => \App\Group::find($idGroup)]);
        
    }

}