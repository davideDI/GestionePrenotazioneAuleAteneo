<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class ReportController extends Controller {
    
    public function getReportView() {
        
        Log::info('ReportController - getReportView()');
        return view('pages/report/report');
        
    }
    
}

