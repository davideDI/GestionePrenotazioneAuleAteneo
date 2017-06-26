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
    
}

?>
