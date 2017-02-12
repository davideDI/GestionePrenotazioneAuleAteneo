@extends('layouts.layout')
    @section('content')
        
        <!-- Div principale contenitore del calendario -->
        <div id="calendar">

        </div>

        <!-- Caricamento script calendario -->
        <script type="text/javascript">
            //Al caricamento della pagina viene inserito il calendario
            $(document).ready(function() {

                var initialLocaleCode = "{{Session::get('applocale')}}";

                $('#calendar').fullCalendar({

                    // Definizione opzioni calendario
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,basicWeek,basicDay'
                            },
                    //defaultDate: '2016-12-12', Se non impostata la data di default viene presa la data odierna
                    navLinks: true, // can click day/week names to navigate views
                    editable: true,
                    eventLimit: true, // Quando ci sono più eventi per una data compare il link view more
                    events: [
                        
                        @foreach($bookings as $booking) 
                            {
                                title: '{{$booking->book_name}}',
                                start: '{{$booking->start_date}}',
                                end:   '{{$booking->end_date}}'
                            }, 
                        @endforeach
                        
                        ],

                        /*
                         * Esempio caricamento lista eventi con chiamata ajax
                         * events: {
                            url: '/myfeed.php',
                            type: 'POST',
                            data: {
                                custom_param1: 'something',
                                custom_param2: 'somethingelse'
                            },
                            error: function() {
                                alert('there was an error while fetching events!');
                            },
                            color: 'yellow',   // a non-ajax option
                            textColor: 'black' // a non-ajax option
                            }
                         */
                    color: 'yellow',   // an option!
                    textColor: 'black', // an option!
                    locale: initialLocaleCode

                });

            });

            // when the selected option changes, dynamically change the calendar option
            function changeCalendarLocale(locale) {
                console.log(locale);
                $('#calendar').fullCalendar('option', 'locale', locale);
            }
            
        </script>
        
    @endsection