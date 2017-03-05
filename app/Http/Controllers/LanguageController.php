<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller {
    
    //switch language
    public function switchLang($lang) {
        
        Log::info('LanguageController - switchLang('.$lang.')');
        
        if (array_key_exists($lang, Config::get('languages'))) {
            Session::set('applocale', $lang);
        }
        return Redirect::back();
    }
    
}
