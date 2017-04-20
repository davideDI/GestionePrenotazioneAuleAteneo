@extends('layouts.layout')
    @section('content')
        
        <div class="row">
            
            <!-- Div con filtri e buttons -->
            <div class="col-md-2">
                
                <!-- Select resource associate al group -->
                <div class="row">
                        
                    <div class="col-md-12">

                        <legend>{{$group->name}}</legend> 
                        <select id="resourceSelect" 
                                onChange="window.location.href=this.value" 
                                class="listOfGroups" 
                                style="width: 70%">
                            <option></option>
                            @foreach($resources as $resource)
                                <option value="{{URL::to('/bookings', [$group->id, $resource->id])}}">
                                    {{$resource->name}}
                                </option>
                            @endforeach
                        </select>

                    </div>
                    
                </div>
                
                <br>
                
                <!-- Tasto Nuovo Evento -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- TODO -->
                        <!-- Al momento solo gli utenti registrati richiedono prenotazioni -->
                        @if(Session::has('session_id'))
                            <a class="btn btn-primary" href="{{URL::to('/new-booking')}}">
                                {{ trans('messages.index_calendar_new_event') }}
                            </a>
                        @else
                            
                        @endif
                    </div>
                </div>
                
                <br><br>
                
                <!-- Legenda stati prenotazione -->
                <div class="row">
                    <div class="col-md-12">
                        <legend>Stati prenotazione</legend>
                        <p>Richiesta &nbsp;&nbsp;<img width="17" height="17" class="img-circle" src="{{URL::asset('lib/images/palla_blu.jpg')}}" /></p>
                        <p>In Lavorazione&nbsp;<img width="17" height="17" class="img-circle" src="{{URL::asset('lib/images/palla_gialla.jpg')}}" /></p>
                        <p>Gestita&nbsp;&nbsp;<img width="17" height="17" class="img-circle" src="{{URL::asset('lib/images/palla_verde.jpg')}}" /></p>
                        <p>Scartata&nbsp;&nbsp;<img width="17" height="17" class="img-circle" src="{{URL::asset('lib/images/palla_rossa.jpg')}}" /></p>
                    </div>
                </div>
                
            </div>
            
            <!-- Div principale -->
            <div class="col-md-10">

                <!-- Div contenitore calendario -->
                <div class="row">
                    <div class="col-md-12" id="calendar"></div>
                </div>
                
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
    
        <!-- Gestione X-CSRF-Token per chiamata Ajax -->
        <script type="text/javascript">
            $.ajaxSetup({
               headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
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
                    
                    //Definizione orari min e max
                    minTime: "08:00:00",
                    maxTime: "20:30:00",                       
                            
                    //defaultDate: '2016-12-12', Se non impostata la data di default viene presa la data odierna
                    navLinks: true, // can click day/week names to navigate views
                    editable: true,
                    
                    //Vista di default
                    defaultView: 'agendaWeek',
                    
                    // Quando ci sono più eventi per una data compare il link view more
                    eventLimit: true, 
                    
                    //Caricamento eventi
                    events: [
                        @foreach($bookings as $booking)
                            {
                                id         : '{{$booking->id}}',
                                title      : '{{$booking->name}}',
                                description: '{{$booking->description}}',
                                start      : '{{$booking->event_date_start}}',
                                end        : '{{$booking->event_date_end}}',
                                @if($booking->tip_booking_status_id == 1) 
                                    color : '#0000FF'
                                @elseif($booking->tip_booking_status_id == 2) 
                                    color : '#FFFF00'
                                @elseif($booking->tip_booking_status_id == 3) 
                                    color : '#00FF00'
                                @else
                                    color : '#FF0000'
                                @endif
                            },
                        @endforeach
                        ],
                        
                    color: 'yellow',   // an option!
                    textColor: 'black', // an option!
                    
                    //Lingua testi (da correggere)
                    locale: initialLocaleCode,
                    
                    //Permette il drop
                    droppable: true,
                    
                    //Eventi client
                    drop: function(date, jsEvent, ui) { 
                        
                    },
                    
                    eventReceive: function( event ) { 
                        
                    },
                    
                    //Al passaggio del mouse sulla prenotazione visualizzo il popover
                    eventMouseover: function( event, jsEvent, view ) { 
                    
                        //Set attributi per la visualizzazione del popover
                        $(this).attr("data-toggle", "popover");
                        $(this).attr("data-placement", "right");
                        $(this).attr("data-content", event.description);
                        $(this).attr("data-container", "body");
                        //Visualizzo il "popover"
                        $(this).popover('show');
                       
                    },
                    
                    //Togliendo il mouse sulla prenotazione il popover verrà nascosto
                    eventMouseout: function( event, jsEvent, view ) { 
                    
                        $(this).popover('hide');
                        
                    },
                    
                    //Spostamento casella rappresentante l'evento
                    eventDrop: function( calEvent, dayDelta, minuteDelta, allDay,
 			 			revertFunc, jsEvent, ui, view ) {  
                        
                        //Recupero dati per update evento
                        var idEvento = calEvent.id;
                        var start = moment(calEvent.start).format("YYYY-MM-DD HH:mm:ss");
                        var end = moment(calEvent.end).format("YYYY-MM-DD HH:mm:ss");
                        
                        //creazione json per chiamata ajax
                        var dataEvent = {
                                'id_evento': idEvento,
                                'data_inizio': start,
                                'data_fine': end
                            };
                        
                        //RIchiamo la funzione che effettua la modifica all'evento
                        updateEvent(dataEvent);
                        
                    },
                    
                    eventDragStart: function( event, jsEvent, ui, view ) {
                        
                    },
                    
                    eventDragStop: function( event, jsEvent, ui, view ) { 
                        
                    },
                    
                    //Modifica "dimensione" casella (durata evento)
                    eventResize: function( event, delta, revertFunc, jsEvent, ui, view ) {
                        
                        //Recupero dati per update evento
                        var idEvento = event.id;
                        var start = moment(event.start).format("YYYY-MM-DD HH:mm:ss");
                        var end = moment(event.end).format("YYYY-MM-DD HH:mm:ss");
                        
                        //creazione json per chiamata ajax
                        var dataEvent = {
                            'id_evento': idEvento,
                            'data_inizio': start,
                            'data_fine': end
                        };
                        
                        //RIchiamo la funzione che effettua la modifica all'evento
                        updateEvent(dataEvent);
                        
                    },
                    
                    //Quando viene caricata la pagine e si visualizza il calendario viene richiamato questo evento
                    viewRender: function() {
                        
                    },
                    
                    // gestione click su evento
                    eventClick: function(calEvent, jsEvent, view) {

                        //alert('Event: ' + calEvent.title);
                        //alert('Event: ' + moment(calEvent.start).format("DD-MM-YYYY HH:mm:ss"));
                        //alert('Event: ' + moment(calEvent.end).format("DD-MM-YYYY HH:mm:ss"));
                        //alert('Event: ' + calEvent.id);

                        //modifico il titolo
                        //calEvent.title = "CLICKED!";
                        //viene apportata la modifica nel calendario
                        //$('#calendar').fullCalendar('updateEvent', calEvent);

                    }

                });

            });
            
            function updateEvent(event) {
                
                //Tramite chiamata ajax vengono modificati i dati dell'evento
                $.ajax({

                    url: "{{URL::to('/updateEvent')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: event,
                    success: function() {
                        alert('Modifica evento avvenuta con successo!');
                    },
                    error: function() {
                        alert('Modifica evento non riuscita!');
                    },

                });
                        
            }

            // when the selected option changes, dynamically change the calendar option
            function changeCalendarLocale(locale) {
                console.log(locale);
                $('#calendar').fullCalendar('option', 'locale', locale);
            }
            
        </script>
        
    @endsection
