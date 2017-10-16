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
        
        if($sessionRole == \App\TipUser::ROLE_ADMIN_ATENEO) {
            
            return $this->getCountAllRepeats();
            
        } else if($sessionRole == \App\TipUser::ROLE_ADMIN_DIP) {
            
            return $this->getCountCheck();
            
        } else if($sessionRole == \App\TipUser::ROLE_INQUIRER) {
            
            return $this->getCountCheck();
            
        }
        
    }
    
    public function getCountAllRepeats() {
        
        Log::info('HomeController - getCountAllRepeats()');
        $repeats = \App\Repeat::whereIn('tip_booking_status_id', [TIP_BOOKING_STATUS_REQUESTED, TIP_BOOKING_STATUS_WORKING])->get();
        return count($repeats);
        
    }
    
    public function getCountRepeats() {
        
        $groupIdToManage = session('group_id_to_manage');
        Log::info('HomeController - getCountRepeats(groupIdToManage: '.$groupIdToManage.')');
        
        $countCheck = 0;
        if($groupIdToManage == null || $groupIdToManage == 0) {
            return $countCheck;
        }
        
        $resources = \App\Resource::where('group_id', $groupIdToManage)->get();
        //Per ogni risorsa
        foreach($resources as $resource) {
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
        return $countCheck;
            
    }
    
    public function getCountCheck() {
        
        $groupIdToManage = session('group_id_to_manage');
        Log::info('HomeController - getCountCheck(groupIdToManage: '.$groupIdToManage.')');
        
        $countSurvey = 0;
        if($groupIdToManage == null || $groupIdToManage == 0) {
            return $countSurvey;
        }
        
        $surveis = Survey::where('tip_survey_status_id', TIP_SURVEY_STATUS_REQUESTED)->get();
        foreach($surveis as $survey) {
            foreach($survey->repeat as $repeat) {
                foreach($repeat->booking as $booking) {
                    foreach($booking->resource as $resource) {
                        if($resource->group_id == $groupIdToManage) {
                            $countSurvey++;
                        }
                    }
                }
            }
        }
        
        return $countSurvey;
            
    }
    
}
