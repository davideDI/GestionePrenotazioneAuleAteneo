<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CheckController extends Controller {
    
    public function getChecksView() {
     
        Log::info('CheckController - getChecksView()');
        return view('pages/check/checks');
        
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
