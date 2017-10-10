<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

include 'Variables.php';

class AclController extends Controller {
    
    public function getAclView() {
        
        Log::info('AclController - getAclView()');
        return view('pages/admin/acl');
        
    }
    
    public function getUsersList() {
        
        Log::info('AclController - getUserList()');
        $listOfAcl = \App\Acl::simplePaginate(1);
        return view('pages/admin/users-list', ['listOfAcl' => $listOfAcl]);
        
    }
    
    public function getManageUserView() {
        
        Log::info('AclController - getManageUserView()');
        return view('pages/admin/manage-users', ['checkSearchTrue' => false]);
        
    }
    
    public function getLdapUserInfo(Request $request) {
        
        Log::info('AclController - getLdapUserInfo()');
        
        $ldap_params_username = $request['cn'];
        $checkUserSearch = true;
         
        $ldap_client_ip = "";
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ldap_client_ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ldap_client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ldap_client_ip = $_SERVER['REMOTE_ADDR'];
        }
        
        $ldap = array(
            "host"                  => Config::get(APP.'.'.LDAP_HOST),	
            "proto"                 => Config::get(APP.'.'.LDAP_PROTO),	
            "port"                  => Config::get(APP.'.'.LDAP_PORT),
            "basedn"                => Config::get(APP.'.'.LDAP_BASE_DN),	
            "user_mask"             => Config::get(APP.'.'.LDAP_USER_MASK),
            "user"                  => 'cn='.Config::get(APP.'.'.LDAP_ADM_USERNAME).','.Config::get(APP.'.'.LDAP_BASE_DN),	
            "filter"                => null,	
            "pass"                  => Config::get(APP.'.'.LDAP_ADM_PASSWORD),	
            "justthese"             => array("cn", "sn", "co", "c", "whenCreated","whenChanged", 
                                            "lastLogon", "badPasswordTime", "pwdLastSet", 
                                            "lastLogonTimestamp", "department", "memberOf",
                                            "employeeType", "telephoneNumber", "distinguishedName",
                                            "userPrincipalName", "accountExpires", "mail",
                                            "preferredLanguage","targetAddress", "proxyAddresses", 
                                            "name", "displayName", "sAMAccountName","uid", "carLicense", 
                                            "eduPersonScopedAffiliation","employeeID","givenName","title"),
            "member_email_domain"   => Config::get(APP.'.'.LDAP_MEMBER_EMAIL_DOMAIN),	
            "student_email_domain"  => Config::get(APP.'.'.LDAP_STUDENT_EMAIL_DOMAIN),	
            "test_password"         => Config::get(APP.'.'.LDAP_TEST_PASSWORD),	
        );

        $ldap_isLogout = null;
        $ldap_result_count = 0;
        $ldap_connection = null;

        $ldap_reply = array(
                "isError"=>false,
                "errorLevel"=>0,
                "data"=>null
        ); 
         
        $ldap_useSSL = (isset($ldap['proto']) && (strtolower($ldap['proto'])=='ssl')) || (isset($ldap['port']) && (intval($ldap['port']) == 636));
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
                                            $ldap_reply["data"]=array();
                                                $ldap['justthese'] = (isset($ldap['justthese']) && ($ldap['justthese'] !== null) && is_array($ldap['justthese']))?$ldap['justthese']:array();
                                                foreach($ldap_fields as $key => $val) {
                                                    if (in_array($key,$ldap['justthese']) && !is_numeric($key)) {
                                                        switch($key) {
                                                            case "whenCreated":
                                                            case "whenChanged":
                                                                $ldap_reply["data"][strtoupper($key)] = LDAP_dateStringReFormat($val[0]);
                                                                break;
                                                            case "employeeID":
                                                                $ldap_reply["data"][$key] = isset($val[0])?$val[0]:$val;
                                                                $ldap_reply["data"]['MATRICOLA'] = isset($val[0])?$val[0]:$val;
                                                            break;
                                                            case "carLicense":
                                                                $ldap_reply["data"][$key] = isset($val[0])?$val[0]:$val;
                                                                $ldap_reply["data"]['COD_FIS'] = isset($val[0])?$val[0]:$val;
                                                            break;
                                                            case "givenName":
                                                                $ldap_reply["data"][$key] = isset($val[0])?$val[0]:$val;
                                                                $ldap_reply["data"]['NOME'] = isset($val[0])?ucwords(strtolower($val[0])):$val;
                                                            break;
                                                            case "sn":
                                                                $ldap_reply["data"][$key] = isset($val[0])?$val[0]:$val;
                                                                $ldap_reply["data"]['COGNOME'] = isset($val[0])?ucwords(strtolower($val[0])):$val;
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
                                                }
                                        } else {
                                            $checkUserSearch = false;
                                        }
                                } else {
                                    $checkUserSearch = false;
                                }
                        } else {
                            $checkUserSearch = false;
                        }
                    } else {
                        $checkUserSearch = false;
                    }
                } else {
                    $checkUserSearch = false;
                }
            } else {
                $checkUserSearch = false;
            }
        } else {
            $checkUserSearch = false;
        }

        $acl = new \App\Acl;
        if($checkUserSearch) {
            $acl->email = $ldap_reply["data"]["mail"];
            $acl->cn = $ldap_reply["data"]["cn"];
            
            $listOfGroups = \App\Group::pluck('name', 'id');
            $listOfTipUser = \App\TipUser::pluck('name', 'id');
        
            return view('pages/admin/manage-users', ['acl' => $acl, 'listOfGroups' => $listOfGroups, 'listOfTipUser' => $listOfTipUser, 'checkSearchTrue' => $checkUserSearch]);
            
        }
        
        return view('pages/admin/manage-users', ['checkSearchTrue' => $checkUserSearch, 'userFinded' => true]);

    }
    
    public function insertUser(Request $request) {
        
        Log::info('AclController - insertUser()');
        
        $acl = new \App\Acl;
        $acl->fill($request->all());
        $acl->save();
        
        return redirect()->route('users-list');
        
    }
    
}

