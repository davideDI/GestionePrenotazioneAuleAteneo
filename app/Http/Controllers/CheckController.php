<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Survey;
use Exception;

class CheckController extends Controller {
    
    public function getChecksView() {
     
        Log::info('CheckController - getChecksView()');
        
        $checkList = Survey::with('repeat')->where('tip_survey_status_id', '=', 1)->get();
        
        return view('pages/check/checks', ['checkList' => $checkList]);
        
    }
    
    public function insertRequestCheck(Request $request) {
        
        $idRepeat = $request['idRepeat'];
        Log::info('CheckController - requestCheck(idRepeat: '.$idRepeat.')');
        
        $survey = new Survey;
        $survey->repeat_id = $idRepeat;
        $survey->requested_by = session('source_id');
        $survey->tip_survey_status_id = 1;
        
        $survey->save();
        
        //TODO compleatare gestione invio email
        //$repeat = \App\Repeat::find($idRepeat);
        //mail($repeat->booking->resource->room_admin_email, "TODO", "TODO");
        
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
            $survey->tip_survey_status_id = 2;

            $survey->save();
            return redirect()->route('checks')->with('success', 'check_booking_ok');
            
        } catch(Exception $ex) {
            Log::error('CheckController - Errore nella verifica della prenotazione: '.$ex->getMessage());
            return redirect()->back()->with('customError', 'check_booking_ko');
        }   
        
    }
    
}

?>
