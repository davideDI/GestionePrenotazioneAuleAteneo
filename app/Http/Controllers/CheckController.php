<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class CheckController extends Controller {
    
    public function getChecksView() {
     
        Log::info('CheckController - getChecksView()');
        return view('pages/check/checks');
        
    }
    
}

?>
