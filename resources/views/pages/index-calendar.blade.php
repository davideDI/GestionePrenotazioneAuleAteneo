@extends('layouts.layout')
    @section('content')
        
        <div class="row">
            
            <!-- Filtri Applicabili -->
            <div class="col-md-2">
                <p>{{$group->name}}</p> 
                <select class="listOfGroups" style="width: 50%">
                    <option></option>
                    @foreach($resources as $resource)
                        <option value="{{$resource->id}}">
                            {{$resource->name}}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Div principale contenitore del calendario -->
            <div class="col-md-10" id="calendar">

            </div>
        </div>

        <!-- Select 2 -->
        <script type="text/javascript">
            $(document).ready(function() {
              $(".listOfGroups").select2({
                  placeholder: "{{ trans('messages.index_calendar_select_room') }}"
              });
            });
        </script>
    
        <!-- Caricamento script calendario -->
        <script type="text/javascript">
            //Al caricamento della pagina viene inserito il calendario
            $(document).ready(function() {

                var initialLocaleCode = "{{Session::get('applocale')}}";
                //Test di visualizzazione lingua
                //console.log(initialLocaleCode);

                $('#calendar').fullCalendar({
                       
                    // Definizione opzioni calendario
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,basicWeek,basicDay,listDay,agendaWeek'
                            },
                    
                    minTime: "08:00:00",
                    maxTime: "20:30:00",
                         
                            
                    //defaultDate: '2016-12-12', Se non impostata la data di default viene presa la data odierna
                    navLinks: true, // can click day/week names to navigate views
                    editable: true,
                    defaultView: 'month',
                    eventLimit: true, // Quando ci sono più eventi per una data compare il link view more
                    events: [
                        
                        @foreach($bookings as $booking) 
                            {
                                id:    '{{$booking->id_event}}',
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
                    locale: initialLocaleCode,
                    
                    //******************************************************************************
                    //Funzionalità di test
                    droppable: true,
                    drop: function(date, jsEvent, ui) { 
                        console.log('Function : drop');
                        console.log(date);
                        console.log(jsEvent);
                        console.log(ui);
                    },
                    eventReceive: function( event ) { 
                        console.log('Function : eventReceive');
                        console.log(event);
                    },
                    eventDrop: function( calEvent, dayDelta, minuteDelta, allDay,
 			 			revertFunc, jsEvent, ui, view ) {  
                        console.log('Function : eventDrop');
                        console.log(event);
                        console.log(dayDelta);
                        console.log(minuteDelta);
                        console.log(allDay);
                        console.log(revertFunc);
                        console.log(jsEvent);
                        console.log(ui);
                        console.log(view);
                    },
                    eventDragStart: function( event, jsEvent, ui, view ) {
                        console.log('Function : eventDragStart');
                        console.log(event); 
                        console.log(jsEvent); 
                        console.log(ui); 
                        console.log(view);
                    },
                    eventDragStop: function( event, jsEvent, ui, view ) { 
                        console.log('Function : eventDragStop');
                        console.log(event); 
                        console.log(jsEvent); 
                        console.log(ui); 
                        console.log(view);
                    },
                    eventResize: function( event, delta, revertFunc, jsEvent, ui, view ) {
                        console.log('Function : eventResize');
                        console.log(event);
                        console.log(delta);
                        console.log(revertFunc);
                        console.log(jsEvent);
                        console.log(ui);
                        console.log(view);
                    },
                    viewRender: function() {
                        console.log('Function : viewRender');
                        //?????
                    },
                    
                    //******************************************************************************
                    // gestione click su evento
                    eventClick: function(calEvent, jsEvent, view) {

                        //alert('Event: ' + calEvent.title);
                        alert('Event: ' + moment(calEvent.start).format("DD-MM-YYYY HH:mm:ss"));
                        alert('Event: ' + moment(calEvent.end).format("DD-MM-YYYY HH:mm:ss"));
                        alert('Event: ' + calEvent.id);

                        // change the border color just for fun
                        //$(this).css('border-color', 'red');

                        //modifico il titolo
                        calEvent.title = "CLICKED!";
                        //viene apportata la modifica nel calendario
                        $('#calendar').fullCalendar('updateEvent', calEvent);

                    }

                });

            });

            // when the selected option changes, dynamically change the calendar option
            function changeCalendarLocale(locale) {
                console.log(locale);
                $('#calendar').fullCalendar('option', 'locale', locale);
            }
            
        </script>
        
    @endsection