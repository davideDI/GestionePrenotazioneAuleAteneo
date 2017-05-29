<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class HelpController extends Controller {
    
    public function getHelpView() {
        
        Log::info('HelpController - getHelpView()');
        return view('pages/help/help');
        
    }
    
}
