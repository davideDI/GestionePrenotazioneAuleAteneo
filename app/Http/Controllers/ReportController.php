<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class ReportController extends Controller {
    
    public function getReportHome() {
        
        Log::info('ReportController - getReportHome()');
        return view('pages/report');
        
    }
    
}

