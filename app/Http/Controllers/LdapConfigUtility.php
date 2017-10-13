<?php

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
