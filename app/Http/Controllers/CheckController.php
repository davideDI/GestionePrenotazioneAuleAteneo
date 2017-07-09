<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CheckController extends Controller {
    
    public function getChecksView() {
     
        Log::info('CheckController - getChecksView()');
        
        $checkList = \App\Survey::with('repeat')->where('tip_survey_status_id', '=', 1)->get();
        
        return view('pages/check/checks', ['checkList' => $checkList]);
        
    }
    
    public function insertRequestCheck(Request $request) {
        
        $idRepeat = $request['idRepeat'];
        Log::info('CheckController - requestCheck(idRepeat: '.$idRepeat.')');
        
        $survey = new \App\Survey;
        $survey->repeat_id = $idRepeat;
        $survey->requested_by = session('source_id');
        $survey->tip_survey_status_id = 1;
        
        $survey->save();
        
        return $survey;
        
    }
    
    public function updateCheck(Request $request) {
        
        $idSurvey = $request['id'];
        Log::info('CheckController - updateCheck(idSurvey: '.$idSurvey.')');
        
        try {
            
            $survey = \App\Survey::find($idSurvey);
        
            $survey->note = $request['note'];
            $survey->real_num_students = $request['real_num_students'];
            $survey->performed_by = session('source_id');
            $survey->tip_survey_status_id = 2;

            $survey->save();

            return redirect()->route('checks')->with('success', 'check_booking_ok');
            
        } catch(Exception $ex) {
            Log::error('CheckController - Errore nella verifica della prenotazione '.$ex->getMessage());
            return redirect()->route('checks')->withErrors('check_booking_ko');
        }   
        
    }
    
}

?>
