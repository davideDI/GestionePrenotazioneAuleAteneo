<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    
    public function getHome() {
        
        Log::info('HomeController - getHome()');
        Session::set('applocale', Config::get('app.locale'));
        $groupsList = App\Group::all();
        return view('pages/index', [ 'groupsList' => $groupsList ]);
        
    }
    
}
