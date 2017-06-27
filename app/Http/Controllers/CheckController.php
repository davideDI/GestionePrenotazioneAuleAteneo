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
        
        Log::info('CheckController - requestCheck()');
        $idRepeat = $request['idRepeat'];
        
        $survey = new \App\Survey;
        $survey->repeat_id = $idRepeat;
        $survey->requested_by = session('source_id');
        $survey->tip_survey_status_id = 1;
        
        $survey->save();
        
        return $survey;
        
    }
    
    public function updateCheck(Request $request) {
        
        Log::info('CheckController - updateCheck()');
        
        $idSurvey = $request['id'];
        $survey = \App\Survey::find($idSurvey);
        
        $survey->note = $request['note'];
        $survey->real_num_students = $request['real_num_students'];
        $survey->performed_by = session('source_id');
        $survey->tip_survey_status_id = 2;
        
        $survey->save();
        
        return redirect()->route('checks');
        
        //TODO una volta effettuato l'update inserire un messaggio di successo
        //TODO valutare se nella pagina report visualizzare tutte le verifiche effettuate dagli operatori 
        
    }
    
}

?>
