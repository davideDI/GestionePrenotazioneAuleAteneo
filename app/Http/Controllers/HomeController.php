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
    public function index() {
        
        Log::info('HomeController - index()');
        
        //imposto la lingua di base, settata nel file di config app.php
        //Se non è presente in sessione la vado ad inserire
        if(Session::has('applocale')) {
            //TODO da verificare
        } else {
            Session::set('applocale', Config::get('app.locale'));
        }
        
        return view('home');
    }
}
