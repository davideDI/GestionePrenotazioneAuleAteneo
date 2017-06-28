<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class ReportController extends Controller {
    
    public function getReportView() {
        
        Log::info('ReportController - getReportView()');
        
        //Report 1
        $surveyStatus1 = \App\Survey::where('tip_survey_status_id', 1)->count();
        $surveyStatus2 = \App\Survey::where('tip_survey_status_id', 2)->count();
        
        //Report 2
        $surveysListChecked = \App\Survey::with('repeat')->where('tip_survey_status_id', 2)->get();
        $totSurveysListChecked = count($surveysListChecked);
        $tot1 = 0;
        $tot2 = 0;
        if($totSurveysListChecked > 0) {
            for($i = 0; $i < $totSurveysListChecked; $i++) {
                
                $realNumStudsTemp = $surveysListChecked[$i]->real_num_students;
                $prevNumStudsTemp = $surveysListChecked[$i]->repeat->booking->num_students;
                $capacityTemp = $surveysListChecked[$i]->repeat->booking->resource->capacity;
                
                $tot1 += ( $realNumStudsTemp / $prevNumStudsTemp ) * 100;
                $tot2 += 100 - $tot1;
                
            }
        }
        
        //Report 3
        $numRepeats = \App\Repeat::all()->count();
        
        return view('pages/report/report', [
                    'surveyStatus1' => $surveyStatus1,
                    'surveyStatus2' => $surveyStatus2,
                    'tot1' => round($tot1, 2),
                    'tot2' => round($tot2, 2),
                    'numSurveys' => $surveyStatus1,
                    'numRepeats' => $numRepeats
            ]);
        
    }
    
}

