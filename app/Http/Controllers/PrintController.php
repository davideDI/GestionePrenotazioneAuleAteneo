<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class PrintController extends Controller {
    
    public function getPrintView() {
        
        Log::info('PrintController - getPrintView()');
        return view('pages/print/print');
    
    }
    
}
