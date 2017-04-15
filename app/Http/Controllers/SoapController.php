<?php

namespace App\Http\Controllers;

use Artisaninweb\SoapWrapper\SoapWrapper;

class SoapController extends Controller {

    protected $soapWrapper;

    public function __construct(SoapWrapper $soapWrapper) {
        $this->soapWrapper = $soapWrapper;
    }
  
    public function wsLogin() {
        
        $this->soapWrapper->add('GenericWSEsse3', function ($service) {
            $service->wsdl('https://segreteriavirtuale.univaq.it/services/ESSE3WS?wsdl');
        });

        $fn_dologin = $this->soapWrapper->call('GenericWSEsse3.fn_dologin', [
            'username' => 'davdei',
            'password' => 'Davidedi90'
        ]);
        
        $sid = 'SESSIONID='.$fn_dologin['sid'];
        
        $fn_retrieve_xml_p = $this->soapWrapper->call('GenericWSEsse3.fn_retrieve_xml_p', [
            'retrieve' => 'GET_ANAG_FROM_SESSION',
            'params'   => $sid
        ]);
        
        return view('pages/testSoap', ['test2' => $fn_retrieve_xml_p]);

    }

}
