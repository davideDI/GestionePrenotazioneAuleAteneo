<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class SearchController extends Controller {
    
    public function getSearchView() {
        
        Log::info('SearchController - getSearchView()');
        
        $groupList = \App\Group::all();
       
        return view('pages/search/search', ['groupsList' => $groupList]);
        
    }
    
}

