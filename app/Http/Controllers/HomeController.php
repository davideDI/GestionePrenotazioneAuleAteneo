<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Group;
use App\Survey;

include 'Variables.php';

class HomeController extends Controller {
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('home');
    }
    
    public function getHome() {
        
        Log::info('HomeController - getHome()');
        Session::set('applocale', Config::get('app.locale'));
        $groupsList = Group::all();
        return view('pages/home/index', [ 'groupsList' => $groupsList ]);
        
    }
    
    public function manageBadge() {
        
        Log::info('HomeController - manageBadge()');
        
        $sessionRole = session('ruolo');
        
        if($sessionRole == \App\TipUser::ROLE_ADMIN_DIP) {
            
            return $this->getCountRepeats();
            
        } else if($sessionRole == \App\TipUser::ROLE_INQUIRER) {
            
            return $this->getCountCheck();
            
        }
        
    }
    
    //TODO una volta associata la matricola al gruppo di appartenenza prendere le prenotazioni
    //    $user_id = 1;
    //    $countRepeats = $this->getCountRepeatsTemp($user_id);
    //    if($countRepeats > 0) {
    //        session(['countRepeatsTemp' => $countRepeats]);
    //    }
    public function getCountRepeats() {
        
        $user_id = session('source_id');
        Log::info('HomeController - getCountRepeats(user_id: )'.$user_id);
        
        $groups = Group::where('admin_id', $user_id)->get();
        $countCheck = 0;
        //Per ogni gruppo
        foreach($groups as $group) {
            //Per ogni risorsa associata ad un gruppo
            foreach($group->resources as $resource) {
                //Per ogni prenotazione associata ad una risorsa
                foreach($resource->bookings as $booking) {
                    foreach($booking->repeats as $repeat) {
                        if($repeat->tip_booking_status_id == TIP_BOOKING_STATUS_REQUESTED 
                                || 
                           $repeat->tip_booking_status_id == TIP_BOOKING_STATUS_WORKING) {
                            $countCheck++;
                        }
                    }
                }    
            }
        }
        return $countCheck;
            
    }
    
    //TODO una volta associata la matricola al gruppo di appartenenza prendere le verifiche associate
    //            $user_id = 4;
    //            $countCheck = $this->getCountCheckTemp();
    //            if($countCheck > 0) {
    //                session(['checkCountTemp' => $countCheck]);
    //            }
    public function getCountCheck() {
        
        Log::info('HomeController - getCountCheck()');
        return Survey::where('tip_survey_status_id', TIP_BOOKING_STATUS_REQUESTED)->count();
            
    }
    
}
