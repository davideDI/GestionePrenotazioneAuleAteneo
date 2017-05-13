<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class SearchController extends Controller {
    
    public function getSearchView() {
        
        Log::info('SearchController - getSearchView()');
        return view('pages/search');
        
    }
    
}

