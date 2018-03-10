<?php

define("MYAPPNAME", "Gestion_Prenotazioni_Aule_Laboratori_App");

//config files
define("APP", "app");
define("LOCAL", "local");
define("APP_ENV", "env");
define("MAIL", "mail");

//Web Service
define("ESSE3_PATH_WSDL", "https://segreteriavirtuale.univaq.it/services/ESSE3WS?wsdl");

//Params Web Service
/* Dal doc del ws di ESSE3
•	L1: Corso di Laurea
•	L2: Corso di Laurea
•	LC5: Laurea Ciclo Unico 5 anni
•	LC6: Laurea Ciclo Unico 6 anni
•	LS: Corso di Laurea Specialistica
•	LM: Corso di Laurea Magistrale
•	LM5: Laurea Magistrale Ciclo Unico 5 anni
•	LM6: Laurea Magistrale Ciclo Unico 6 anni
•	D: Corso di Diploma
•	D1: Corso di Dottorato
•	DU: Diploma Universitario
•	M1: Master di Primo Livello
•	M2: Master di Secondo Livello
•	S1: SCUOLA DI SPECIALIZZAZIONE
•	SDFS: Scuola Diretta ai Fini Speciali
•	SHSP: Corso di Specializzazione
 */
define("WS_TIP_CORSO_LIST", "'L1', 'L2', 'LC5', 'LC6', 'LS', 'LM', 'LM5', 'LM6', 'D', 'D1', 'DU', 'M1', 'M2', 'S1', 'SDFS', 'SHSP'");

//LDAP
define("MEMBER", 'Utente');
define("STAFF", 'Personale TA');
define("STUDENT", 'Studenti');
define("PROFESSOR", 'Docenti');
define('LDAP_NO_ERROR',  0);
define('LDAP_WARNING',   1);
define('LDAP_ERROR',     2);
define('LDAP_EXCEPTION', 3);

//LDAP Config
define('LDAP_ENABLE_LOGIN', 'LDAP_ENABLE_LOGIN');

define('LDAP_ADM_USERNAME', 'LDAP_ADM_USERNAME');
define('LDAP_ADM_PASSWORD', 'LDAP_ADM_PASSWORD');
define('LDAP_HOST', 'LDAP_HOST');
define('LDAP_PORT', 'LDAP_PORT');
define('LDAP_PROTO', 'LDAP_PROTO');
define('LDAP_BASE_DN', 'LDAP_BASE_DN');
define('LDAP_USER_MASK', 'LDAP_USER_MASK');
define('LDAP_FILTER', 'LDAP_FILTER');
define('LDAP_JUST_THESE', 'LDAP_JUST_THESE');
define('LDAP_MEMBER_EMAIL_DOMAIN', 'LDAP_MEMBER_EMAIL_DOMAIN');
define('LDAP_STUDENT_EMAIL_DOMAIN', 'LDAP_STUDENT_EMAIL_DOMAIN');
define('LDAP_TEST_PASSWORD', 'LDAP_TEST_PASSWORD');

//Mails
define('ENABLE_SEND_MAIL', 'ENABLE_SEND_MAIL');

define('VAR_AA', 'VAR_AA');
