<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class AclController extends Controller {
    
    public function getAclView() {
        
        Log::info('AclController - getAclView()');
        return view('pages/acl');
        
    }
    
}

