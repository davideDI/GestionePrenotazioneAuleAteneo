<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Survey;
use Exception;

class CheckController extends Controller {
    
    public function getChecksView() {
     
        $groupIdToManage = session('group_id_to_manage');
        Log::info('CheckController - getChecksView(groupIdToManage: '.$groupIdToManage.')');
        
        $checkList = Survey::with('repeat', 'repeat.booking', 'repeat.booking.resource')
                            ->whereHas('repeat.booking.resource', function($q) use ($groupIdToManage) {
                                $q->where('group_id', '=', $groupIdToManage);
                            })
                            ->get();
        
        return view('pages/check/checks', ['checkList' => $checkList]);
        
    }
    
    public function insertRequestCheck(Request $request) {
        
        $idRepeat = $request['idRepeat'];
        Log::info('CheckController - requestCheck(idRepeat: '.$idRepeat.')');
        
        $survey = new Survey;
        $survey->repeat_id = $idRepeat;
        $survey->requested_by = session('source_id');
        $survey->tip_survey_status_id = TIP_SURVEY_STATUS_REQUESTED;
        
        $survey->save();
        
        //TODO compleatare gestione invio email
        if(Config::get(MAIL.'.'.ENABLE_SEND_MAIL)) {
            mail("ADMIN_EMAIL", "SUBJECT", "MESSAGE");
        }
        
        return $survey;
        
    }
    
    public function updateCheck(Request $request) {
        
        $idSurvey = $request['id'];
        Log::info('CheckController - updateCheck(idSurvey: '.$idSurvey.')');
        
        try {
            
            $survey = Survey::find($idSurvey);
        
            $survey->note = $request['note'];
            $survey->real_num_students = $request['real_num_students'];
            $survey->performed_by = session('source_id');
            $survey->tip_survey_status_id = TIP_SURVEY_STATUS_OK;

            $survey->save();
            return redirect()->route('checks')->with('success', 'check_booking_ok');
            
        } catch(Exception $ex) {
            Log::error('CheckController - Errore nella verifica della prenotazione: '.$ex->getMessage());
            return redirect()->back()->with('customError', 'check_booking_ko');
        }   
        
    }
    
}
