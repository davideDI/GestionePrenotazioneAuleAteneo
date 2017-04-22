<?php

namespace App\Http\Controllers;

use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class SoapController extends Controller {

    protected $soapWrapper;

    public function __construct(SoapWrapper $soapWrapper) {
        $this->soapWrapper = $soapWrapper;
    }
  
    private function checkFakeUsersForLogin($username) {
        
        if($username == 'davide@davide.it') {
            session(['session_id' => '999ooo888iii']);
            session(['source_id' => '654321']);
            session(['nome'      => 'DAVIDE']);
            session(['cognome'   => 'DAVIDE']);
            session(['cod_fis'   => 'DAVIDEDAVIDE33']);
            session(['ruolo'     => 'admin']);
            session(['matricola' => 'davide@davide']);
            return true;
        }
        
        else if($username == 'ateneo@ateneo.it') {
            session(['session_id' => '222eee333rrr']);
            session(['source_id' => '123456']);
            session(['nome'      => 'ATENEO']);
            session(['cognome'   => 'ATENEO']);
            session(['cod_fis'   => 'ATENEOATENEO33']);
            session(['ruolo'     => 'admin']);
            session(['matricola' => 'ateneo@ateneo.it']);
            return true;
        }
        
        else {
            return false;
        }
    }
    
    public function wsLogin() {
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        //gestione utenza fittizia per sviluppo
        if($this->checkFakeUsersForLogin($username)) {
            return redirect('/');
        } else {
        
            $this->soapWrapper->add('GenericWSEsse3', function ($service) {
                $service->wsdl('https://segreteriavirtuale.univaq.it/services/ESSE3WS?wsdl');
            });

            $fn_dologin = $this->soapWrapper->call('GenericWSEsse3.fn_dologin', [
                'username' => $username,
                'password' => $password
            ]);

            $sessionID = (string) $fn_dologin['sid'];
            $sid = 'SESSIONID='.$sessionID;

            $fn_retrieve_xml_p = $this->soapWrapper->call('GenericWSEsse3.fn_retrieve_xml_p', [
                'retrieve' => 'GET_ANAG_FROM_SESSION',
                'params'   => $sid
            ]);

            //Codice di risposta
            $responseCode = $fn_retrieve_xml_p['fn_retrieve_xml_pReturn'];

            //se il codice di risposta è 1 non ci sono stati errori
            if($responseCode == 1) {

                //Xml di risposta
                $response = new \SimpleXMLElement($fn_retrieve_xml_p['xml']);

                $row = $response->children()->children()->children();
                $sourceID = (string) $row->SOURCE_ID;
                $nome = (string) $row->NOME;
                $cognome = (string) $row->COGNOME;
                $codFis = (string) $row->COD_FIS;
                $ruolo = (string) $row->RUOLO;
                $matricola = (string) $row->MATRICOLA;

                session(['session_id' => $sessionID]);
                session(['source_id' => $sourceID]);
                session(['nome'      => $nome]);
                session(['cognome'   => $cognome]);
                session(['cod_fis'   => $codFis]);
                session(['ruolo'     => $ruolo]);
                session(['matricola' => $matricola]);

                return redirect('/');

            } else {
                return Redirect::back()->withErrors([$responseCode]);
            }
           
        }

    }
    
    private function checkFakeUsersForLogout() {
        
        $matricola = session('matricola');
        
        if($matricola == 'davide@davide.it' || $matricola == 'ateneo@ateneo.it') {
            return true;
        } else {
            return false;
        }
        
    }
    
    public function wsLogout() {
        
        if(!$this->checkFakeUsersForLogout()) {
            
            $sessionId = session('session_id');
            $sid = 'SESSIONID='.$sessionId;

            $this->soapWrapper->add('GenericWSEsse3', function ($service) {
                $service->wsdl('https://segreteriavirtuale.univaq.it/services/ESSE3WS?wsdl');
            });

            $fn_doLogout = $this->soapWrapper->call('GenericWSEsse3.fn_doLogout', [
                'params' => $sid
            ]);
        
        }
        
        Session::forget('session_id');
        Session::forget('source_id');
        Session::forget('nome');
        Session::forget('cognome');
        Session::forget('cod_fis');
        Session::forget('ruolo');
        Session::forget('matricola');
        
        return redirect('/');
        
    }

}
