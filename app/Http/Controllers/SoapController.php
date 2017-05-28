<?php

namespace App\Http\Controllers;

use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

class SoapController extends Controller {

    protected $soapWrapper;

    public function __construct(SoapWrapper $soapWrapper) {
        $this->soapWrapper = $soapWrapper;
    }
  
    private function checkFakeUsersForLogin($username) {
        
        if($username == 'davide@davide.it') {
            session(['session_id' => '999ooo888iii']);
            session(['source_id' => '1']); //Look at UserTableSeed.php
            session(['nome'      => 'DAVIDE']);
            session(['cognome'   => 'DAVIDE']);
            session(['cod_fis'   => 'DAVIDEDAVIDE33']);
            session(['ruolo'     => 'admin']);
            session(['matricola' => 'davide@davide']);
            return true;
        }
        
        else if($username == 'ateneo@ateneo.it') {
            session(['session_id' => '222eee333rrr']);
            session(['source_id' => '3']); //Look at UserTableSeed.php
            session(['nome'      => 'ATENEO']);
            session(['cognome'   => 'ATENEO']);
            session(['cod_fis'   => 'ATENEOATENEO33']);
            session(['ruolo'     => 'admin']);
            session(['matricola' => 'ateneo@ateneo.it']);
            return true;
        }
        
        else if($username == 'rossi') {
            
            $this->wsGetUdDocPart();
            return true;
            
        }
        
        else {
            return false;
        }
    }
    
    public function wsLogin() {
        
        Log::info('SoapController - wsLogin()');
        
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
        
        if($matricola == 'davide@davide.it' || $matricola == 'ateneo@ateneo.it' || $matricola == '001642') {
            return true;
        } else {
            return false;
        }
        
    }
    
    public function wsLogout() {
        
        Log::info('SoapController - wsLogout()');
        
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
    
    public function wsGetUdDocPart() {
        
        $username = $_POST['username'];
        $year = '2016';
        Log::info('SoapController - wsGetUdDocPart('.$username.')');

        $this->soapWrapper->add('GenericWSEsse3', function ($service) {
            $service->wsdl('https://segreteriavirtuale.univaq.it/services/ESSE3WS?wsdl');
        });

        $params = 'AA_OFF_ID='.$year.';DOCENTE_MATRICOLA='.$username;

        $fn_retrieve_xml_p = $this->soapWrapper->call('GenericWSEsse3.fn_retrieve_xml_p', [
            'retrieve' => 'GET_UD_DOC_PART',
            'params'   => $params
        ]);

        //Codice di risposta
        $responseCode = $fn_retrieve_xml_p['fn_retrieve_xml_pReturn'];

        //se il codice di risposta è 1 non ci sono stati errori
        if($responseCode == 1) {
            $xml = new \SimpleXMLElement($fn_retrieve_xml_p['xml']);
            $list = $xml->children()->children();

            $result = array();
            $nome = "";
            $cognome = "";
            for($i = 0; $i < count($list); $i++) {
                if((string)$list[$i]->AA_ORD_ID == $year) {
                    $temp = (string)$list[$i]->CDS_COD." - ".(string)$list[$i]->UD_DES.' - '.(string)$list[$i]->UD_COD;
                    Log::info('SoapController - wsGetUdDocPart('.$temp.')');
                    $result += array(
                        (string)$list[$i]->UD_COD => $temp,
                        /*"CDS_COD" => (string)$list[$i]->CDS_COD,
                        "CDS_DES" => (string)$list[$i]->CDS_DES,
                        "DIP_COD" => (string)$list[$i]->DIP_COD,
                        "DIP_DES" => (string)$list[$i]->DIP_DES,
                        "AA_ORD_ID" => (string)$list[$i]->AA_ORD_ID,
                        "PDS_COD" => (string)$list[$i]->PDS_COD,
                        "PDS_DES" => (string)$list[$i]->PDS_DES,
                        "AD_COD" => (string)$list[$i]->AD_COD,
                        "AD_DES" => (string)$list[$i]->AD_DES,
                        "UD_COD" => (string)$list[$i]->UD_COD,
                        "UD_DES" => (string)$list[$i]->UD_DES,
                        "AR_ID" => (string)$list[$i]->AR_ID,
                        "DOCENTE_MATRICOLA" => (string)$list[$i]->DOCENTE_MATRICOLA,
                        "DOCENTE_NOME" => (string)$list[$i]->DOCENTE_NOME,
                        "DOCENTE_COGNOME" => (string)$list[$i]->DOCENTE_COGNOME,
                        "SEDE_DES" => (string)$list[$i]->SEDE_DES,
                        "MASTER_FLG" => (string)$list[$i]->MASTER_FLG,
                        "TIPO_CORSO" => (string)$list[$i]->TIPO_CORSO,
                        "CFU_TOTALI_AD" => (string)$list[$i]->CFU_TOTALI_AD,
                        "ORE_PREVISTE_MODULO" => (string)$list[$i]->ORE_PREVISTE_MODULO,
                        "ORE_PREVISTE_AD" => (string)$list[$i]->ORE_PREVISTE_AD   */                     
                    );
                    $nome = (string)$list[$i]->DOCENTE_NOME;
                    $cognome = (string)$list[$i]->DOCENTE_COGNOME;
                }
            }
            session(['session_id' => 'id_test']);
            session(['source_id'  => $username]);
            session(['nome'       => $nome]);
            session(['cognome'    => $cognome]);
            session(['matricola'  => $username]);
            session(['ruolo'      => 'docente']);
            session(['listOfTeachings' => $result]);
            return redirect('/');
        }
    }

}