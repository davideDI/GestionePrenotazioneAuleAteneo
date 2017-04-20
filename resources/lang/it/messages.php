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
        
        //Messages from common
        'common_save' => 'Salva',
        'common_close' => 'Chiudi',
        'common_title' => 'Titolo',
        'common_description' => 'Descrizione',
        
        //Messages from insert event
        'booking_title' => 'Inserisci una nuova prenotazione',
        'booking_date_hour_start' => 'Dalle ore',
        'booking_date_hour_end' => 'Alle ore',
        'booking_date_day_start' => 'Data inizio evento',
        'booking_date_day_end' => 'Data fine evento',
        'booking_date_booking' => 'Data prenotazione',
        'booking_date_resource' => 'Risorsa',
        'booking_date_group' => 'Gruppo',
        'booking_date_select_group' => 'Seleziona un gruppo',
        'booking_date_select_resource' => 'Seleziona una risorsa',
        'booking_type_event' => 'Seleziona tipo evento',
        'booking_event' => 'Evento',
        
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
        
        //Success Messages [from 100 to 299]
        '100' => 'Prenotazione effettuata! ',
        
        //Warning Messages [from 300 to 499]
        
        //Error Messages [from 500 to 699]
        '500' => 'Errore nell\'inserimento della prenotazione',
        
        //Response code
        //WS LOGIN
        '-1' => 'Errore nel recupero dei dati',
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

