<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    
    //switch language
    public function switchLang($lang) {
        if (array_key_exists($lang, Config::get('languages'))) {
            Session::set('applocale', $lang);
        }
        return Redirect::back();
    }
    
}
