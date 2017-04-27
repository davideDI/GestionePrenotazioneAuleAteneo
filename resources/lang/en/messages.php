<?php

    //   INGLESE

    return [
        
        //Messages from menu
        'home' => 'Home',
        'home_title' => 'Booking Rooms and Laboratory',
        'home_report' => 'Report',
        'home_print' => 'Print',
        'home_help' => 'Help',
        'home_rooms' => 'Rooms',
        'home_search' => 'Search',
        'home_find_rooms' => 'Find Rooms',
        'home_login' => 'Login',
        'home_logout' => 'Logout',
        'home_console' => 'Console',
        'home_meta_description' => 'Booking Rooms and Laboratory - Univaq',
        
        //Messages from home page
        'home_welcome' => 'Welcome to the management system and reservation classrooms and teaching laboratories',
        'home_sub_section' => 'Select the area of ​​your relevance',
        
        //Messages from footer
        'footer_title' => 'Booking system for Rooms and Labs',
        'footer_title_univaq' => 'University of L\'Aquila',
        'footer_privacy_cookies' => 'Privacy and Cookies',

        ///Messages from index-calendar.blade
        'index_calendar_select_room' => 'Select a room',
        'index_calendar_new_event' => 'New Event',
        'index_calendar_new_booking' => 'New Reservation',
        'index_calendar_booking_status' => 'Booking status',
        'index_calendar_requested' => 'Requested',
        'index_calendar_in_process' => 'In process',
        'index_calendar_managed' => 'Managed',
        'index_calendar_rejected' => 'Rejected',
        
        ///Messages from common
        'common_save' => 'Save',
        'common_close' => 'Close',
        'common_title' => 'Title',
        'common_description' => 'Description',
        'common_danger' => 'Reservation Not Accepted!',
        'common_success' => 'Accepted Booking!',
        
        //Messages from insert booking
        'booking_title' => 'Insert new Booking',
        'booking_date_hour_start' => 'From',
        'booking_date_hour_end' => 'To',
        'booking_date_day_start' => 'Date from',
        'booking_date_day_end' => 'Date end',
        'booking_date_booking' => 'Booking date',
        'booking_date_resource' => 'Resource',
        'booking_date_group' => 'Group',
        'booking_date_select_group' => 'Selece a group',
        'booking_date_select_resource' => 'Select a resource',
        'booking_type_event' => 'Select a type event',
        'booking_event' => 'Event',
        
        //Messages from help page
        'help_contact' => 'Contact',
        'help_contact_text' => 'For many information about rooms bookings contact:',
        'help_contact_list1' => 'Academic Office of your department or structure\'s manager',
        'help_contact_list2' => 'Head of academic logistics management: doc. Luca Testa',
        'help_contact_list3' => 'Secretary of the General Manager: doc. Anna Maria Nardecchia',
        'help_auth' => 'Authentication',
        'help_auth_text' => 'The login is only for the secretarial staff. '
        . '                  Contact the admin if you have any problems. '
        . '                  Many options are avaible only for the admins. '
        . '                  If the system is configured with LDAP, you must use the same email\'s credentials.',
        
        //Console page
        'console_booking_ok' => 'Bookings confirmed',
        'console_booking_working' => 'Bookings in workings',
        'console_booking_request' => 'Bookings in queque',
        'console_booking_ko' => 'Bookings rejected',
        'console_booking_there_are' => 'There are ',
        'console_booking_there_arent' => 'There aren\'t ',
        'console_no_groups' => 'You don\'t have any groups to manage!',
        'console_manage' => 'Approve',
        'console_reject' => 'Reject',
        
        //Success Messages [from 100 to 299]
        '100' => 'Reservation saved!',
        
        //Warning Messages [from 300 to 499]
        
        //Error Messages [from 500 to 699]
        '500' => 'Error in the inclusion of reservation',
        
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
