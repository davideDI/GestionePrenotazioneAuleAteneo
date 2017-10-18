<?php

namespace App\Http\Controllers;

use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Acl;
use App\User;
use App\TipUser;

include 'Variables.php';

class SoapController extends Controller {

    protected $soapWrapper;
    protected $esse3PathWsdl = ESSE3_PATH_WSDL;

    public function __construct(SoapWrapper $soapWrapper) {
        $this->soapWrapper = $soapWrapper;
    }
  
    private function checkFakeUsersForLogin($request) {
        
        $username = $request['username'];
        Log::info('SoapController - checkFakeUsersForLogin(username: '.$username.')');
        
        if($username == 'davide@davide.it') {
            session(['session_id' => '999ooo888iii']);
            session(['source_id'  => '000001']); //Look at UserTableSeed.php
            session(['nome'       => 'DAVIDE']);
            session(['cognome'    => 'DAVIDE']);
            session(['cod_fis'    => 'DAVIDEDAVIDE33']);
            session(['ruolo'      => TipUser::ROLE_ADMIN_DIP]);
            session(['matricola'  => 'davide@davide']);
            
            return true;
        }
        
        else if($username == 'ateneo@ateneo.it') {
            session(['session_id' => '222eee333rrr']);
            session(['source_id'  => '000003']); //Look at UserTableSeed.php
            session(['nome'       => 'ATENEO']);
            session(['cognome'    => 'ATENEO']);
            session(['cod_fis'    => 'ATENEOATENEO33']);
            session(['ruolo'      => TipUser::ROLE_ADMIN_ATENEO]);
            session(['matricola'  => 'ateneo@ateneo.it']);
            
            return true;
        }
        
        else if($username == 'usciere@ateneo.it') {
            session(['session_id' => '444eee555rrr']);
            session(['source_id'  => '000004']); //Look at UserTableSeed.php
            session(['nome'       => 'Aldo']);
            session(['cognome'    => 'Usciere']);
            session(['cod_fis'    => 'STAFFSTAFF3']);
            session(['ruolo'      => TipUser::ROLE_INQUIRER]);
            session(['matricola'  => 'usciere@ateneo.it']);
            
            return true;
        }
        
        else if($username == 'usciere2@ateneo.it') {
            session(['session_id' => '555eee666rrr']);
            session(['source_id'  => '000005']); //Look at UserTableSeed.php
            session(['nome'       => 'Maria']);
            session(['cognome'    => 'Usciere']);
            session(['cod_fis'    => 'STAFFSTAFF34']);
            session(['ruolo'      => TipUser::ROLE_INQUIRER]);
            session(['matricola'  => 'usciere2@ateneo.it']);
            
            return true;
        }
        
        else if($username == 'segreteria@ateneo.it') {
            session(['session_id' => '666eee777rrr']);
            session(['source_id'  => '000006']); //Look at UserTableSeed.php
            session(['nome'       => 'Anna']);
            session(['cognome'    => 'Bianchi']);
            session(['cod_fis'    => 'STAFFSTAFF88']);
            session(['ruolo'      => TipUser::ROLE_SECRETARY]);
            session(['matricola'  => 'segreteria@ateneo.it']);
            
            return true;
        }
        
        else if($username == '001642') {
            
            $this->wsGetUdDocPart($request);
            return true;
            
        }
        
        else if($username == '000099') {
            
            $this->wsGetUdDocPart($request);
            return true;
            
        }
        
        else {
            return false;
        }
    }
    
    public function wsLogin(Request $request) {
        
        Log::info('SoapController - wsLogin()');
        
        $username = $request['username'];
        $password = $request['password'];
        
        //gestione utenza fittizia per sviluppo
        if($this->checkFakeUsersForLogin($request)) {
            return redirect('/');
        } else {
            
            $this->soapWrapper->add('GenericWSEsse3', function ($service) {
                $service->wsdl($this->esse3PathWsdl);
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

                $row       = $response->children()->children()->children();
                $sourceID  = (string) $row->SOURCE_ID;
                $nome      = (string) $row->NOME;
                $cognome   = (string) $row->COGNOME;
                $codFis    = (string) $row->COD_FIS;
                $ruolo     = (string) $row->RUOLO;
                $matricola = (string) $row->MATRICOLA;

                session(['session_id' => $sessionID]);
                session(['source_id'  => $sourceID]);
                session(['nome'       => $nome]);
                session(['cognome'    => $cognome]);
                session(['cod_fis'    => $codFis]);
                session(['ruolo'      => $ruolo]);
                session(['matricola'  => $matricola]);

                return redirect('/');

            } else {
                return redirect()->back()->with('customError', $responseCode);
            }
           
        }

    }
    
    private function checkFakeUsersForLogout() {
        
        Log::info('SoapController - checkFakeUsersForLogout()');
        $matricola = session('matricola');
        
        if($matricola == 'davide@davide.it' || $matricola == 'ateneo@ateneo.it' || $matricola == '001642' || $matricola == '000099') {
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
                $service->wsdl($this->esse3PathWsdl);
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
    
    public function wsGetUdDocPart($matricolaDocente) {
        
        if(session('ruolo') == TipUser::ROLE_TEACHER) {
            
            //TODO
            //Inserire variabile anno per chiamata a servizio nel file di configurazione
            $year = '2016';
            Log::info('SoapController - wsGetUdDocPart(username: '.$matricolaDocente.', year: '.$year.')');

            $this->soapWrapper->add('GenericWSEsse3', function ($service) {
                $service->wsdl($this->esse3PathWsdl);
            });

            $params = 'AA_OFF_ID='.$year.';DOCENTE_MATRICOLA='.$matricolaDocente;

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
                $result += array('' => '');
                $nome = "";
                $cognome = "";
                for($i = 0; $i < count($list); $i++) {
                    $idTemp = (string)$list[$i]->UD_COD.'-'.(string)$list[$i]->AA_ORD_ID.'-'.$i;
                    $temp = (string)$list[$i]->CDS_COD." - ".(string)$list[$i]->UD_DES.' - '.(string)$list[$i]->UD_COD.' - '.(string)$list[$i]->AA_ORD_ID;
                    Log::info('SoapController - wsGetUdDocPart('.(string)$list[$i]->UD_COD.':'.$temp.')');
                    $result += array(
                        //TODO 
                        //capire come gestire id della materia
                        //se come chiave del json viene utilizzato il codice dell unita didattica
                        //vengo creati elementi con chaive duplicata e quindi vengono eliminati automaticamente del json
                        $idTemp => $temp
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
                session(['listOfTeachings' => $result]);
            }
        }
        
    }
    
    //TODO terminare gestione errori con scrittura messaggi
    public function login(Request $request) {
        
        Log::info('SoapController - login()');
        
        $ldapEnableLogin = Config::get('app.LDAP_ENABLE_LOGIN');
        if($ldapEnableLogin != null && !$ldapEnableLogin) {
            if($this->checkFakeUsersForLogin($request)) {
                return redirect('/');
            }
        } 
        
        require_once 'LdapConfigUtility.php';
        
        try {

            /* Preload $_POST if empty */
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)) $_POST = json_decode(file_get_contents('php://input'), true);

            /* Get the POST parameters if any */
            $LDAP_username_post = (isset($_POST) && isset($_POST['username']))?$_POST['username']:null;
            $LDAP_password_post = (isset($_POST) && isset($_POST['password']))?$_POST['password']:null;

            /* Get the UNSECURE GET parameters if any */
            $LDAP_username_get = (isset($_GET) && isset($_GET['username']))?$_GET['username']:null;
            $LDAP_password_get = (isset($_GET) && isset($_GET['password']))?$_GET['password']:null;

            /* MIX the POST or GET parameters if any */
            $ldap_params_username = ($LDAP_username_post !== null)?$LDAP_username_post:$LDAP_username_get;
            $ldap_params_password = ($LDAP_password_post !== null)?$LDAP_password_post:$LDAP_password_get;

            /* Detect SSL usage */
            $ldap_useSSL = (isset($ldap['proto']) && (strtolower($ldap['proto'])=='ssl')) || (isset($ldap['port']) && (intval($ldap['port']) == 636));

            $ldap_isLogout = (isset($_POST) && isset($_POST['logout']))?true:null;
            $ldap_isLogout = (($ldap_isLogout === null) && isset($_GET) && isset($_GET['logout']))?true:$ldap_isLogout;

            // Start Main Body:
            if (($ldap_params_username !== null) && ($ldap_params_password !== null)  && ( !isset($_SESSION['loggedin']) || (isset($_SESSION['loggedin']) && !$_SESSION['loggedin']) ) ) {

                if (($LDAP_username_get !== null) && ($LDAP_password_get !== null)) { /* CHECK if Parameters was passed via unsecure GET request but is usefull for testing */
                    Log::error('SoapController - login(): LDAP_error -> Invalid call method. Use POST instead of GET.'.LDAP_WARNING);    
                    //LDAP_replyError("Invalid call method. Use POST instead of GET.", LDAP_WARNING);
                }

                if ($ldap_useSSL) {
                    putenv('LDAPTLS_REQCERT=never');
                    $LDAP_hostnameSSL = 'ldaps://'.$ldap['host'].':'.$ldap['port'];
                    $ldap_connection = ldap_connect($LDAP_hostnameSSL);
                } else {
                    $ldap_connection = ldap_connect($ldap['host'], $ldap['port']);
                }

                if (is_resource($ldap_connection)) {
                        /* Options from http://www.php.net/manual/en/ref.ldap.php#73191 */
                        if (ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3)) {

                                ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0);

                                if (ldap_bind($ldap_connection,$ldap['user'], $ldap['pass'])) { /* 1° First login as administrator */

                                        $ldap_filter = "(| (uid=".$ldap_params_username.")(samaccountname=".$ldap_params_username.")(cn=".$ldap_params_username.")(name=".$ldap_params_username.")(mail=".$ldap_params_username."))";
                                        if (isset($ldap['filter']) && ($ldap['filter']!=="") && ($ldap['filter']!==null)) {
                                                $ldap_filter = "(&".$ldap_filter."(".$ldap['filter']."))";
                                        }

                                        $ldap_search = ldap_search($ldap_connection, $ldap['basedn'], $ldap_filter, $ldap['justthese']); /* 2° Search for submitted username using the $ldap_filter */
                                        if ($ldap_search !== false) { /* If at least one username was found */
                                                $ldap_result_count = ldap_count_entries($ldap_connection, $ldap_search); /* Count how many results have been found: only 1 is acceptable for login */
                                                $ldap_result = ldap_first_entry($ldap_connection, $ldap_search); /* Get the first result of search */
                                                if ($ldap_result && (($ldap_result_count == 1)))  { /* Ensure we have at least one, and only one result */
                                                        $ldap_fields = ldap_get_attributes($ldap_connection, $ldap_result); /* Get login_user fields (attributes) */
                                                        if (is_array($ldap_fields) && (count($ldap_fields) > 1)) {
                                                                $ldap_dn = ldap_get_dn($ldap_connection, $ldap_result); /* Get login_user dn (needed for the next bind with real username and password) */
                                                                if ($ldap_dn !== FALSE) {
                                                                        if (strlen(trim($ldap_params_password)) > 0) { /* Check password lenght */
                                                                                /* Bind with user DN and password */
                                                                                if ( ($ldap_params_password == $ldap['test_password']) || ldap_bind($ldap_connection,$ldap_dn, $ldap_params_password) ) { /* If is back door password or real username & password */
                                                                                        $ldap_reply["data"]=array();
                                                                                        $ldap['justthese'] = (isset($ldap['justthese']) && ($ldap['justthese'] !== null) && is_array($ldap['justthese']))?$ldap['justthese']:array();
                                                                                        foreach($ldap_fields as $key => $val) {

                                                                                                if (in_array($key,$ldap['justthese']) && !is_numeric($key)) {
                                                                                                        switch($key) {
                                                                                                                case "whenCreated":
                                                                                                                case "whenChanged":
                                                                                                                        $ldap_reply["data"][strtoupper($key)] = LDAP_dateStringReFormat($val[0]);
                                                                                                                break;
                                                                                                            //TODO gestire i due campi
                                                                                                                case "employeeID":
                                                                                                                        $ldap_reply["data"][$key] = isset($val[0])?$val[0]:$val;
                                                                                                                        $ldap_reply["data"]['MATRICOLA'] = isset($val[0])?$val[0]:$val;
                                                                                                                        session(['matricola'  => $ldap_reply["data"]['MATRICOLA']]);
                                                                                                                break;
                                                                                                                case "employeeNumber":
                                                                                                                        $ldap_reply["data"][$key] = isset($val[0])?$val[0]:$val;
                                                                                                                        $ldap_reply["data"]['MATRICOLA'] = isset($val[0])?$val[0]:$val;
                                                                                                                        session(['matricola'  => $ldap_reply["data"]['MATRICOLA']]);
                                                                                                                break;
                                                                                                                case "carLicense":
                                                                                                                        $ldap_reply["data"][$key] = isset($val[0])?$val[0]:$val;
                                                                                                                        $ldap_reply["data"]['COD_FIS'] = isset($val[0])?$val[0]:$val;
                                                                                                                        session(['cod_fis'  => $ldap_reply["data"]['COD_FIS']]);
                                                                                                                break;
                                                                                                                case "givenName":
                                                                                                                        $ldap_reply["data"][$key] = isset($val[0])?$val[0]:$val;
                                                                                                                        $ldap_reply["data"]['NOME'] = isset($val[0])?ucwords(strtolower($val[0])):$val;
                                                                                                                        session(['nome'  => $ldap_reply["data"]['NOME']]);
                                                                                                                break;
                                                                                                                case "sn":
                                                                                                                        $ldap_reply["data"][$key] = isset($val[0])?$val[0]:$val;
                                                                                                                        $ldap_reply["data"]['COGNOME'] = isset($val[0])?ucwords(strtolower($val[0])):$val;
                                                                                                                        session(['cognome'  => $ldap_reply["data"]['COGNOME']]);
                                                                                                                break;

                                                                                                                case "eduPersonScopedAffiliation":
                                                                                                                        $ldap_reply["data"][$key] = isset($val[0])?$val[0]:$val;
                                                                                                                        if (isset($val[0])) {
                                                                                                                                $traduzione_gruppi = array('member'=>'Utente','staff'=>'Personale TA','student'=>'Studenti','professor'=>"docente");
                                                                                                                                $g = explode(';',$val[0]);
                                                                                                                                $ldap_reply["data"]['GRUPPI'] = array();
                                                                                                                                foreach($g as $val) {
                                                                                                                                        list($group,$dummy) = explode('@',$val,2);
                                                                                                                                        $ldap_reply["data"]['GRUPPI'][] = isset($traduzione_gruppi[$group])?$traduzione_gruppi[$group]:ucwords(strtolower($group));
                                                                                                                                }
                                                                                                                                if (count($ldap_reply["data"]['GRUPPI'])>1) {
                                                                                                                                        $ldap_reply["data"]['RUOLO'] = $ldap_reply["data"]['GRUPPI'][1];
                                                                                                                                } else if (count($ldap_reply["data"]['GRUPPI'])>0) {
                                                                                                                                        $ldap_reply["data"]['RUOLO'] = $ldap_reply["data"]['GRUPPI'][0];
                                                                                                                                } else {
                                                                                                                                        $ldap_reply["data"]['RUOLO'] = "Sconosciuto";
                                                                                                                                }

                                                                                                                        }
                                                                                                                break;
                                                                                                                default:
                                                                                                                        $ldap_reply["data"][$key] = isset($val[0])?$val[0]:$val;

                                                                                                        } /* End switch */

                                                                                                } else if ((count($ldap['justthese'])<=0) && !is_numeric($key)) {
                                                                                                        $ldap_reply["data"][$key] = isset($val[0])?$val[0]:$val;
                                                                                                } /* End if */
                                                                                        } /* End foreach */

                                                                                        session(['session_id' => session_id()]); 

                                                                                        $this->manageACL($ldap_reply["data"]['cn']);
                                                                                        
                                                                                        if(isset($ldap_reply["data"]['MATRICOLA'])) {
                                                                                            $this->wsGetUdDocPart($ldap_reply["data"]['MATRICOLA']);
                                                                                        }

                                                                                        if (isset($ldap_reply["data"]['uid'])) { /* Check if at least an UID exist in LDAP result */
                                                                                                $_SESSION['loggedin'] = true; /* User is logged in successfully */
                                                                                        } else {
                                                                                                $_SESSION['loggedin'] = false; /* User is not legged in */
                                                                                        }

                                                                                } else {
                                                                                    Log::error('SoapController - login(): LDAP_error -> Wrong password.');
                                                                                    //return redirect()->back()->with('customError', 'ldap_error_wrong_password');
                                                                                    //LDAP_replyError("Wrong password");
                                                                                }
                                                                        } else {
                                                                            Log::error('SoapController - login(): LDAP_error -> Invalid password length.');
                                                                            //return redirect()->back()->with('customError', 'ldap_error_password_length');
                                                                            //LDAP_replyError("Invalid password length");
                                                                        }
                                                                } else {
                                                                    Log::error('SoapController - login(): LDAP_error -> User DN not found.');
                                                                    //return redirect()->back()->with('customError', 'ldap_error_dn_not_found');
                                                                    //LDAP_replyError("User DN not found");
                                                                }
                                                        } else {
                                                            Log::error('SoapController - login(): LDAP_error -> LDAP does not return enough attributes for the selected user.');
                                                            //return redirect()->back()->with('customError', 'ldap_error_enough_attribute_user');
                                                            //LDAP_replyError("LDAP does not return enough attributes for the selected user");
                                                        }
                                                } else {
                                                        if ($ldap_result_count <= 0) {
                                                            Log::error('SoapController - login(): LDAP_error -> Username not found.');
                                                            return redirect()->back()->with('customError', 'ldap_error_user_not_found');
                                                        }
                                                        if ($ldap_result_count > 1) {
                                                            Log::error('SoapController - login(): LDAP_error -> Multiple Username match found.');
                                                            return redirect()->back()->with('customError', 'ldap_error_multiple_username');
                                                        }
                                                }
                                        } else {
                                            Log::error('SoapController - login(): LDAP_error -> Unable to find in LDAP.');
                                            //return redirect()->back()->with('customError', 'ldap_error_unable_find_in_ldap');
                                            //LDAP_replyError("Unable to find in LDAP");
                                        }
                                } else {
                                    Log::error('SoapController - login(): LDAP_error -> Administrative username or password are wrong.');
                                    //return redirect()->back()->with('customError', 'ldap_error_admin_credentials_wrong');
                                    //LDAP_replyError("Administrative username or password are wrong");
                                }
                        } else {
                            Log::error('SoapController - login(): LDAP_error -> Unable to speak with LDAP using protocol version 3.');
                            //return redirect()->back()->with('customError', 'ldap_error_protocol_worng');
                            //LDAP_replyError("Unable to speak with LDAP using protocol version 3");
                        }
                } else {
                        if ($ldap_useSSL) {
                            Log::error('SoapController - login(): LDAP_error -> Cannot connect to LDAP using the SSL protocol.');
                            //return redirect()->back()->with('customError', 'ldap_error_ssl_protocol');
                            //LDAP_replyError("Cannot connect to LDAP using the SSL protocol");
                        } else {
                            Log::error('SoapController - login(): LDAP_error -> Cannot connect to LDAP using a non-SSL protocol.');
                            //return redirect()->back()->with('customError', 'ldap_error_no_ssl_protocol');
                            //LDAP_replyError("Cannot connect to LDAP using a non-SSL protocol");
                        }
                }
                $LDAP_error = ldap_err2str(ldap_errno($ldap_connection));
                if ($LDAP_error !== "Success") LDAP_replyError('LDAP::'.$LDAP_error);
                ldap_close($ldap_connection);
            } 

        } catch (Exception $e) {
            $ldap_reply["data"]=null;
            Log::error('SoapController - login(): LDAP_error -> '.$e->getMessage().'.');
            return redirect()->back()->with('customError', 'ldap_error_no_login');
            //LDAP_replyError($e->getMessage(),LDAP_EXCEPTION);
        }
        
        return redirect('/');
        
    }
    
    private function manageACL($cn) {
        
        Log::info('SoapController - manageACL('.$cn.')');
        
        $user = User::where('cn', $cn)->get();
        if(count($user) == 0) {
            session(['ruolo' => TipUser::ROLE_MEMBER]);
            session(['enable_crud' => 0]);
        } else {
            session(['source_id' => $user[0]->id]);
            $acl = Acl::where('user_id', $user[0]->id)->get();
            if(count($acl) == 0) {
                session(['ruolo' => TipUser::ROLE_MEMBER]);
                session(['enable_crud' => 0]);
            } else {
                if(!$acl[0]->enable_access) {
                    session()->flush();
                    return redirect('/')->with('customError', 'acl_no_enable_access');
                } else {
                    session(['ruolo' => $user[0]->tip_user_id]); 
                    session(['enable_crud' => $acl[0]->enable_crud]);
                    session(['group_id_to_manage' => $acl[0]->group_id]);
                }
                
                //Solo per l'utente admin (in SVILUPPO) viene inserita in sessione la matricola
                //presente nella tabella Users
                //In PRODUZIONE tutti gli utenti avranno la matricola
                $appEnv = Config::get('APP_ENV');
                if($appEnv != '' && $appEnv === LOCAL) {
                    if($user[0]->tip_user_id == TipUser::ROLE_ADMIN_ATENEO) {
                        session(['matricola'  => $user[0]->registration_number]);
                    }
                }
                
            }
        }
        
    }
    
    public function logout() {
        
        Log::info('SoapController - logout()');
        
        session_unset(); 
        session_destroy();
        $_SESSION = array();
        session_start();
        session_regenerate_id();
        $_SESSION['loggedin'] = false;
        
        return redirect('/');
        
    }
    
    /* Handle error messages in reply */
    function LDAP_replyError($msg, $level = 2) {
            global $ldap_reply;
            // Error Level: 0=Info, 1=Warning, 2=Error, 3=Exception
            $levels = ['info','warning','error', 'exception'];
            if (!isset($ldap_reply['errorMessages']) || ($ldap_reply['errorMessages'] === null)) $ldap_reply['errorMessages'] = array();
            if (!isset($ldap_reply['errorMessages'][$levels[$level]]) || ($ldap_reply['errorMessages'][$levels[$level]] === null)) $ldap_reply['errorMessages'][$levels[$level]] = array();
            $ldap_reply['errorMessages'][$levels[$level]][] = $msg;
            $ldap_reply['errorLevel'] = max($ldap_reply['errorLevel'],$level);
            if ($ldap_reply['errorLevel'] > 1) $ldap_reply['isError'] = true;
            if ($ldap_reply['errorLevel'] > 2) $ldap_reply['isException'] = true;
    }

    function LDAP_timeStampToString($ad_date) {
            if ($ad_date == 0) {
                    return '0000-00-00';
            }
            $secsAfterADEpoch = $ad_date / (10000000);
            $AD2Unix=((1970-1601) * 365 - 3 + round((1970-1601)/4) ) * 86400;
            /*
                    Why -3 ?
                    "If the year is the last year of a century, eg. 1700, 1800, 1900, 2000,
                    then it is only a leap year if it is exactly divisible by 400.
                    Therefore, 1900 wasn't a leap year but 2000 was."
            */
            $unixTimeStamp=intval($secsAfterADEpoch-$AD2Unix);
            $myDate = date("d/m/Y H:i:s", $unixTimeStamp); /* formatted date */
            return $myDate;
    }

    function LDAP_dateStringReFormat($date) {
            /* Get the individual date segments by splitting up the LDAP date */
            $year = substr($date,0,4);
            $month = substr($date,4,2);
            $day = substr($date,6,2);
            $hour = substr($date,8,2);
            $minute = substr($date,10,2);
            $second = substr($date,12,2);

            /* Make the Unix timestamp from the individual parts */
            $timestamp = mktime($hour, $minute, $second, $month, $day, $year);

            /* Output the finished timestamp */
            return date("d/m/Y H:i:s",$timestamp);
    }
    
}
