<?php

    //   ITALIANO

    return [
        
        //Messages from menu
        'home' => 'Home',
        'home_title' => 'Prenotazione Aule e Laboratori',
        'home_report' => 'Report',
        'home_print' => 'Stampa',
        'home_help' => 'Aiuto',
        'home_rooms' => 'Aule',
        'home_search' => 'Ricerca',
        'home_find_rooms' => 'Cerca Aule',
        'home_login' => 'Login',
        'home_logout' => 'Logout',
        'home_console' => 'Console',
        'home_acl' => 'ACL',
        'home_manage_resources' => 'Gestione Risorse',
        'home_meta_description' => 'Occupazione Aule e Laboratori - Univaq',
        
        //Messages from home page
        'home_welcome' => 'Benvenuti nel sistema di gestione e prenotazione aule e laboratori didattici di Ateneo',
        'home_sub_section' => 'Selezionare l\'area di vostra pertinenza',
        
        //Messages from footer
        'footer_title' => 'Sistema Prenotazione Aule Didattiche e Laboratori',
        'footer_title_univaq' => 'Università degli Studi dell\'Aquila',
        'footer_privacy_cookies' => 'Informativa su Privacy ed Uso dei Cookies',
        
        //Messages from index-calendar.blade
        'index_calendar_select_room' => 'Seleziona una risorsa',
        'index_calendar_new_event' => 'Nuovo Evento',
        'index_calendar_new_booking' => 'Effettua prenotazione',
        'index_calendar_booking_status' => 'Stati prenotazione',
        'index_calendar_types_event' => 'Tipologie Eventi',
        'index_calendar_requested' => 'Richiesta',
        'index_calendar_in_process' => 'In lavorazione',
        'index_calendar_managed' => 'Gestita',
        'index_calendar_rejected' => 'Scartata',
        'index_calendar_generic' => 'Generico',
        'index_calendar_seminary' => 'Seminario',
        'index_calendar_exam' => 'Esame',
        'index_calendar_lesson' => 'Lezione',
        'index_calendar_capacity' => 'Posti',
        'index_calendar_booked_at' => 'Prenotato il : ',
        'index_calendar_num_students' => 'Studenti previsti : ',
        'index_calendar_event' => 'Evento : ',
        'index_calendar_repeats' => 'Ripetizioni',
        'index_calendar_event_start' => 'Inizio evento : ',
        'index_calendar_event_end' => 'Fine evento : ',
        'index_calendar_booked_by' => 'Prenotato da : ',
        
        //Messages from common
        'common_save' => 'Salva',
        'common_close' => 'Chiudi',
        'common_title' => 'Titolo',
        'common_name' => 'Nome',
        'common_description' => 'Descrizione',
        'common_danger' => 'Prenotazione Respinta!',
        'common_success' => 'Prenotazione Accettata!',
        'common_structure' => 'Struttura',
        'common_room_name' => 'Nome Aula',
        'common_email_adimn' => 'Email Gestore',
        'common_reservation' => 'Prenota',
        
        //Messages from insert booking
        'booking_title' => 'Inserisci una nuova prenotazione',
        'booking_date_hour_start' => 'Dalle',
        'booking_date_hour_end' => 'Alle',
        'booking_date_day_start' => 'Data inizio evento',
        'booking_date_day_end' => 'Data fine evento',
        'booking_date_booking' => 'Data prenotazione',
        'booking_date_resource' => 'Risorsa',
        'booking_date_group' => 'Gruppo',
        'booking_date_select_group' => 'Seleziona un gruppo',
        'booking_date_select_resource' => 'Seleziona una risorsa',
        'booking_date_select_teachings' => 'Seleziona una materia',
        'booking_date_teachings' => 'Materie',
        'booking_type_event' => 'Seleziona tipo evento',
        'booking_event' => 'Evento',
        'booking_num_students' => 'Numero Studenti',
        'booking_capacity' => 'Capienza',
        'booking_room_admin_email' => 'Email Admin',
        'booking_projector' => 'Proiettore',
        'booking_screen_motor' => 'Schermo Motorizzato',
        'booking_screen_manual' => 'Schermo Manuale',
        'booking_audio' => 'Impianto Audio',
        'booking_pc' => 'PC Fisso',
        'booking_wire_mic' => 'Microfono Collegato',
        'booking_wireless_mic' => 'Microfono Wireless',
        'booking_overhead_projector' => 'Videoproiettore',
        'booking_visual_presenter' => 'Presentatore visivo',
        'booking_wiring' => 'Cablaggio',
        'booking_equipment' => 'Attrezzatura',
        'booking_blackboard' => 'Lavagna',
        'booking_note' => 'Note',
        'booking_note_nd' => 'Non definite',
        'booking_network' => 'Num prese rete',
        'booking_resource_information' => 'Specifiche Risorsa',
        'booking_multiple_event' => 'Evento Ripetuto',
        'booking_single_event' => 'Singolo Evento',
        'booking_type_repeat_monday' => 'Lunedì',
        'booking_type_repeat_tuesday' => 'Martedì',
        'booking_type_repeat_wednesday' => 'Mercoledì',
        'booking_type_repeat_thursday' => 'Giovedì',
        'booking_type_repeat_friday' => 'Venerdi',
        'booking_type_repeat_saturday' => 'Sabato',
        'booking_place_available' => 'Posti Disponibili',
        'booking_warning_student' => 'Attenzione, la seguente prenotazione verrà registrata con la matricola associata al vostro account.',
        
        //Messages from help page
        'help_contact' => 'Contatti',
        'help_contact_text' => 'Per informazioni in merito all\'assegnazione delle aule, contattare:',
        'help_contact_list1' => 'Segreteria Area Didattica del vostro dipartimento o responsabile della vostra struttura',
        'help_contact_list2' => 'Responsabile Area Gestione Logistica per la Didattica: dott. Luca Testa',
        'help_contact_list3' => 'Segreteria del Direttore Generale: dott.ssa Anna Maria Nardecchia',
        'help_auth' => 'Autenticazione',
        'help_auth_text' => 'L\'accesso al sistema è riservato al personale delle Strutture. '
        . '                  Contatta l\'amministratore se hai problemi di autenticazione. '
        . '                  Alcune funzionalità sono accessibili solo per i gestori della Struttura, gli altri riceveranno '
        . '                  questo messaggio Non hai i permessi per modificare questo ogetto. '
        . '                  Contatta l\'amministratore per ulteriori informazioni. '
        . '                  Se il sistema è configurato per utilizzare l\'autenticazione LDAP, significa che devi utilizzare '
        . '                  le stesse credenziali che utilizzi per accedere all\'email.',
        
        //Console page
        'console_booking_ok' => 'Prenotazioni Accolte',
        'console_booking_working' => 'Prenotazioni in lavorazione',
        'console_booking_request' => 'Prenotazioni richieste',
        'console_booking_ko' => 'Prenotazioni respinte',
        'console_booking_there_are' => 'Ci sono ',
        'console_booking_there_arent' => 'Non ci sono ',
        'console_no_groups' => 'Lei non ha Gruppi da amministrare!',
        'console_manage' => 'Approva',
        'console_reject' => 'Respingi',
        
        //Manage-resource page
        'manage_resource_title' => 'Gestione Risorse',
        'manage_resource_no_resources' => 'Nessuna Risorsa presente!',
        'manage_resource_inset_group' => 'Inserisci Gruppo',
        'manage_resource_inset_resource' => 'Inserisci Risorsa',
        'manage_resource_group_title' => 'Inserisci nuovo Gruppo',
        'manage_resource_resource_title' => 'Inserisci nuova Risorsa',
        'manage_resource_tip_group_title' => 'Tipo Gruppo',
        'manage_resource_' => '',
        'manage_resource_' => '',
        'manage_resource_' => '',
        
        //Search-page
        'search_title' => 'Cerca Aule',
        'search_capacity' => 'Capacità minima',
        'search_group' => 'Gruppi',
        'search_date' => 'Giorno',
        'search_duration' => 'Durata',
        'search_search_capacity' => 'Cerca Aule per Capienza',
        'search_search_free' => 'Cerca Aule Libere',
        
        
        //Success Messages [from 100 to 299]
        '100' => 'Prenotazione effettuata! ',
        
        //Warning Messages [from 300 to 499]
        
        //Error Messages [from 500 to 699]
        '500' => 'Errore nell\'inserimento della prenotazione',
        
        //Response code
        //WS LOGIN
        '-1'   => 'Errore nel recupero dei dati',
        '1003' => 'Autenticazione fallita',
        '1004' => 'Fallita la creazione del componente',
        '1007' => 'Fallita la connessione al DB',
        '1110' => 'Utente disabilitato',
        '1112' => 'La password deve essere impostata (cambio password al primo login)',
        '1116' => 'User_id non valido o nullo',
        '1119' => 'Il gruppo a cui appartiene l\'utente non è abilitato ad utilizzare questo tipo di client',
        '1126' => 'Errore generico di LDAP',
        '1130' => 'Password scaduta',
        
    ];

