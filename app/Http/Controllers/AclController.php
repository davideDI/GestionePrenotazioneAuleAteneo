<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Acl;
use App\Group;
use App\TipUser;
use App\User;

class AclController extends Controller {
    
    public function getUsersList() {
        
        Log::info('AclController - getUserList()');
        $listOfAcl = Acl::with('group', 'user')->get();
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
         
        require_once 'LdapConfigUtility.php';
        
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

        if($checkUserSearch) {
            $user = new User;
            $user->email = $ldap_reply["data"]["mail"];
            $user->cn = $ldap_reply["data"]["cn"];
            $user->registration_number = $ldap_reply["data"]['employeeNumber'];
            $user->name = $ldap_reply["data"]['NOME'];
            $user->surname = $ldap_reply["data"]['COGNOME'];
            
            $listOfGroups = Group::pluck('name', 'id');
            $listOfTipUser = TipUser::pluck('name', 'id');
        
            return view('pages/admin/manage-users', ['user' => $user, 'listOfGroups' => $listOfGroups, 'listOfTipUser' => $listOfTipUser, 'checkSearchTrue' => $checkUserSearch]);
            
        }
        
        return view('pages/admin/manage-users', ['checkSearchTrue' => $checkUserSearch, 'userFinded' => true]);

    }
    
    public function insertUser(Request $request) {
        
        Log::info('AclController - insertUser()');
        $user = new User;
        $user->fill($request->all());
        $user->save();
        
        $acl = new Acl;
        $acl->user_id = $user->id;
        $acl->group_id = $request['group_id'];
        $acl->enable_crud = $request->enable_crud ? 1 : 0;
        $acl->enable_access = $request->enable_access ? 1 : 0;
        $acl->save();
        
        return redirect()->route('users-list')->with('success', 'common_insert_ok');
        
    }
    
    public function updateAclView($idAcl) {
        
        Log::info('AclController - updateAclView('.$idAcl.')');
        $acl = Acl::where('id', $idAcl)->with('user')->get();
        $listOfGroups = Group::pluck('name', 'id');
        $listOfTipUser = TipUser::pluck('name', 'id');
        return view('pages/admin/acl', ['acl' => $acl[0], 'listOfGroups' => $listOfGroups, 'listOfTipUser' => $listOfTipUser]);
        
    }
    
    public function updateAcl(Request $request) {
        
        Log::info('AclController - updateAcl()');
        
        $acl = Acl::find($request->id);
        $acl->group_id = $request->group_id;
        $acl->enable_crud = $request->enable_crud ? 1 : 0;
        $acl->enable_access = $request->enable_access ? 1 : 0;
        $acl->save();
        
        $user = User::find($acl->user_id);
        $user->tip_user_id = $request->tip_user_id;
        $user->save();
        
        return redirect()->route('users-list')->with('success', 'common_update_ok');
        
    }
    
    public function deleteAcl(Request $request) {
        
        Log::info('AclController - deleteAcl()');
        $acl = Acl::find($request->id);
        $idUser = $acl->user_id;
        $user = User::find($idUser);
        $user->delete();
        $acl->delete();
        return redirect()->route('users-list')->with('success', 'common_update_ok');
        
    }
    
}
