<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class ResourceController extends Controller {
    
    public function getResourceView() {
        
        Log::info('ResourcesController - getResourceView()');
        return view('pages/resources');
        
    }
    
}
