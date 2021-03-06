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
                                class="listOfResources"
                                style="width: 90%">
                            <option></option>
                            @foreach($resources as $resource)
                                <option value="{{URL::to('/bookings', [$group->id, $resource->id])}}">
                                    {{$resource->name}} ({{$resource->capacity}} {{ trans('messages.index_calendar_capacity') }})
                                </option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <br>

                <!-- Tasto Nuovo Evento -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- Solo gli utenti registrati (o l'admin di ateneo) e abilitati per lo specifico gruppo possono richiedere prenotazioni -->
                        @if(Session::has('session_id')
                                &&
                            Session::has('enable_crud')
                                &&
                            Session::get('enable_crud') == '1'
                                &&
                            (Session::get('group_id_to_manage') == $group->id || Session::get('ruolo') == \App\TipUser::ROLE_ADMIN_ATENEO || Session::get('ruolo') == \App\TipUser::ROLE_STUDENT))
                            <a class="btn btn-primary univaq_button" href="{{URL::to('/new-booking')}}">
                                {{ trans('messages.index_calendar_new_event') }}
                            </a>
                        @endif
                    </div>
                </div>

                <br><br>

                <div class="row">
                    <div class="col-md-12">
                        <!-- Solo gli utenti NON studenti visualizzano la legenda stati prenotazione -->
                        @if(Session::has('session_id') && Session::get('ruolo') != \App\TipUser::ROLE_STUDENT && Session::get('ruolo') != \App\TipUser::ROLE_INQUIRER)
                            <legend>{{ trans('messages.index_calendar_booking_status')}}</legend>
                            @foreach($bookingsStatus as $bookingStatus)
                                @if($bookingStatus->id == 1)
                                    <p>
                                        <img width="30" class="img-circle" src="{{URL::asset('lib/images/richiesta.png')}}" />
                                        {{ trans('messages.index_calendar_requested')}}&nbsp;&nbsp;
                                    </p>
                                @elseif($bookingStatus->id == 2)
                                    <p>
                                        <img width="30" class="img-circle" src="{{URL::asset('lib/images/elaborazione.png')}}" />
                                        {{ trans('messages.index_calendar_in_process')}}&nbsp;&nbsp;
                                    </p>
                                @elseif($bookingStatus->id == 3)
                                    <p>
                                        <img width="30" class="img-circle" src="{{URL::asset('lib/images/checked.png')}}" />
                                        {{ trans('messages.index_calendar_managed')}}&nbsp;&nbsp;
                                    </p>
                                @else
                                    <p>
                                      <img width="30" class="img-circle" src="{{URL::asset('lib/images/x-button.png')}}" />
                                      {{ trans('messages.index_calendar_rejected')}}&nbsp;&nbsp;
                                    </p>
                                @endif
                            @endforeach
                        <!-- Gli utenti studenti visualizzano le tipologie di eventi -->
                        @else
                            <legend>{{ trans('messages.index_calendar_types_event')}}</legend>
                            @foreach($eventsType as $eventType)
                                @if($eventType->id == 1)
                                    <p>
                                        <img width="30" class="img-circle" src="{{URL::asset('lib/images/esame.png')}}" />
                                        {{ trans('messages.index_calendar_exam')}}&nbsp;&nbsp;
                                    </p>
                                @elseif($eventType->id == 2)
                                     <p>
                                        <img width="30" class="img-circle" src="{{URL::asset('lib/images/lezione.png')}}" />
                                        {{ trans('messages.index_calendar_lesson')}}&nbsp;&nbsp;
                                    </p>
                                @elseif($eventType->id == 3)
                                    <p>
                                        <img width="30" class="img-circle" src="{{URL::asset('lib/images/seminario.png')}}" />
                                        {{ trans('messages.index_calendar_seminary')}}&nbsp;&nbsp;
                                    </p>
                                @else
                                    <p>
                                        <img width="30" class="img-circle" src="{{URL::asset('lib/images/generico.png')}}" />
                                        {{ trans('messages.index_calendar_generic')}}&nbsp;&nbsp;
                                    </p>
                                @endif
                            @endforeach
                        @endif
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

            <!-- Modal for set information -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel"></h4>
                        </div>
                        <div id="modalBody" class="modal-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('messages.common_close') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Select 2 -->
        <script type="text/javascript">
            $(document).ready(function() {
              $(".listOfResources").select2({
                  placeholder: "{{ $selectedResource->name }} ({{ $selectedResource->capacity}} {{trans('messages.index_calendar_capacity')}}) "
              })
            });
        </script>

        <!-- Caricamento script calendario -->
        <script type="text/javascript">
            //Al caricamento della pagina viene inserito il calendario
            $(document).ready(function() {

                var initialLocaleCode = "{{Session::get('applocale')}}";
                var typeUser = "{{Session::get('ruolo')}}";

                $('#calendar').fullCalendar({

                    // Definizione opzioni calendario
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,basicDay,listDay'
                            },
                    minTime: "08:00:00", //Definizione orari min
                    maxTime: "20:30:00", //Definizione orari max
                    //defaultDate: '2016-12-12', Se non impostata la data di default viene presa la data odierna
                    navLinks: true, // can click day/week names to navigate views
                    editable: true, // onclick sull'evento
                    locale: initialLocaleCode, //Lingua testi
                    eventDroppableEditable: false, //disabilitato il drop dell'evento
                    eventDurationEditable: false,  //disabilitato il resize dell'evento
                    defaultView: 'agendaWeek', //Vista di default
                    eventLimit: true, // Quando ci sono più eventi per una data compare il link view more

                    allDaySlot: false,
                    contentHeight: 'auto',

                    //Caricamento eventi
                    events: [
                        @foreach($bookings as $booking)
                            @foreach($booking->repeats as $repeat)
                                //gli utenti non loggati oppure gli utenti Studenti visualizzano solo le prenotazioni
                                //in stato 3 [Gestita]
                                @if(!Session::has('ruolo') || Session::get('ruolo') == \App\TipUser::ROLE_STUDENT)
                                    @if($repeat->tip_booking_status_id == \App\TipBookingStatus::TIP_BOOKING_STATUS_OK)
                                        {
                                            id         : '{{$booking->id}}',
                                            title      : '{{$booking->name}}',
                                            description: '{{$booking->subject_id}}',
                                            start      : '{{$repeat->event_date_start}}',
                                            end        : '{{$repeat->event_date_end}}',
                                            @if($booking->tip_event_id == \App\TipEvent::TIP_EVENT_EXAM)
                                                color : '#6ac259'
                                            @elseif($booking->tip_event_id == \App\TipEvent::TIP_EVENT_LESSON)
                                                color : '#e21b1b'
                                            @elseif($booking->tip_event_id == \App\TipEvent::TIP_EVENT_SEMINARY)
                                                color : '#dbba05'
                                            @else
                                                color : '#4a73c5'
                                            @endif
                                        },
                                    @endif
                                //gli utenti non loggati oppure gli utenti Studenti visualizzano solo le prenotazioni
                                //in stato 3 [Gestita]
                                @elseif(Session::has('ruolo') && Session::get('ruolo') != \App\TipUser::ROLE_STUDENT)
                                        {
                                            id         : '{{$booking->id}}',
                                            title      : '{{$booking->name}}',
                                            description: '{{$booking->subject_id}}',
                                            start      : '{{$repeat->event_date_start}}',
                                            end        : '{{$repeat->event_date_end}}',
                                            @if($repeat->tip_booking_status_id == \App\TipBookingStatus::TIP_BOOKING_STATUS_REQUESTED)
                                                color : '#4a73c5'
                                            @elseif($repeat->tip_booking_status_id == \App\TipBookingStatus::TIP_BOOKING_STATUS_WORKING)
                                                color : '#dbba05'
                                            @elseif($repeat->tip_booking_status_id == \App\TipBookingStatus::TIP_BOOKING_STATUS_OK)
                                                color : '#6ac259'
                                            @else
                                                color : '#e21b1b'
                                            @endif
                                        },
                                @endif
                            @endforeach
                        @endforeach
                        ],

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

                    //Spostamento casella rappresentante l'evento (disabilitato)
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

                        //Si richiama la funzione che effettua la modifica all'evento
                        //updateEvent(dataEvent);

                    },

                    eventDragStart: function( event, jsEvent, ui, view ) {

                    },

                    eventDragStop: function( event, jsEvent, ui, view ) {

                    },

                    //Modifica "dimensione" (durata evento) casella (disabilitato)
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

                        //Si richiama la funzione che effettua la modifica all'evento
                        //updateEvent(dataEvent);

                    },

                    //Quando viene caricata la pagine e si visualizza il calendario viene richiamato questo evento
                    viewRender: function() {

                    },

                    // gestione click su evento (disabilitato)
                    eventClick: function(calEvent, jsEvent, view) {
                        /*
                        alert('Event: ' + calEvent.title);
                        alert('Event: ' + moment(calEvent.start).format("DD-MM-YYYY HH:mm:ss"));
                        alert('Event: ' + moment(calEvent.end).format("DD-MM-YYYY HH:mm:ss"));
                        alert('Event: ' + calEvent.id);

                        //modifico il titolo
                        calEvent.title = "CLICKED!";
                        //viene apportata la modifica nel calendario
                        $('#calendar').fullCalendar('updateEvent', calEvent);
                        */
                        $.ajax({
                            data : {'booking_id' : calEvent.id },
                            url : "{{URL::to('/booking')}}",
                            dataType : 'json',
                            type : 'POST',
                            success : function (result) {

                                var title = "";
                                if(result[0].subject_id !== 'N.D.') {
                                    title += result[0].subject_id;
                                } else {
                                    title += result[0].name;
                                }

                                $('#myModalLabel').html("<p>" + title + "</p>");
                                var textForModal = "";
                                textForModal += "<p><strong>{{trans('messages.index_calendar_booked_at')}}</strong>" + moment(result[0].created_at).format("DD-MM-YYYY HH:mm:ss") + "</p>";
                                if(result[0].user.surname === null || result[0].user.name === null) {
                                    // textForModal += "<p><strong>{{trans('messages.index_calendar_booked_by')}}</strong>" + result[0].user.registration_number + "</p>";
                                    textForModal += "<p><strong>{{trans('messages.index_calendar_booked_by')}}</strong> Admin </p>";
                                } else {
                                    textForModal += "<p><strong>{{trans('messages.index_calendar_booked_by')}}</strong>" + result[0].user.surname + " " + result[0].user.name + "</p>";
                                }
                                if(result[0].teacher_id !== null && result[0].teacher_id !== 'N.D.') {
                                    textForModal += "<p><strong>{{trans('messages.index_calendar_teacher_id')}}</strong>" + result[0].teacher_id + "</p>";
                                }
                                textForModal += "<p><strong>{{trans('messages.index_calendar_num_students')}}</strong>" + result[0].num_students + "</p>";
                                textForModal += "<p><strong>{{trans('messages.index_calendar_event')}}</strong>" + result[0].tip_event.name + "</p>";
                                //textForModal += "<p><strong>{{trans('messages.index_calendar_repeats')}}</strong></p>";
                                for (var x=0; x < result[0].repeats.length; x++) {
                                    textForModal += "<hr>";
                                    textForModal += "<div>";
                                    textForModal += "<p><strong>{{trans('messages.index_calendar_repeats')}}: </strong>" + moment(result[0].repeats[x].event_date_start).format("DD-MM-YYYY HH:mm:ss") + " | " + moment(result[0].repeats[x].event_date_end).format("DD-MM-YYYY HH:mm:ss") + "&nbsp;&nbsp;";
                                    @if(Session::has('ruolo') && (Session::get('ruolo') == \App\TipUser::ROLE_ADMIN_ATENEO || Session::get('ruolo') == \App\TipUser::ROLE_ADMIN_DIP))
                                        if(result[0].repeats[x].tip_booking_status_id == "{{\App\TipBookingStatus::TIP_BOOKING_STATUS_OK}}" && result[0].repeats[x].surveys.length == 0) {
                                            textForModal += "<button class='btn btn-primary univaq_button marginRight5px' onclick='inspectBooking("+result[0].repeats[x].id+")'><span onmouseover='$(this).popover(show);' onmouseout='$(this).popover(hide);' class='glyphicon glyphicon-check univaq_menu_span' data-toggle='popover' data-placement='bottom' data-content='test' data-container='body' aria-hidden='true'></span></button>";
                                        }
                                    @endif
                                    @if(Session::has('ruolo') && Session::get('ruolo') == \App\TipUser::ROLE_ADMIN_ATENEO)
                                        if(result[0].repeats[x].tip_booking_status_id != "{{\App\TipBookingStatus::TIP_BOOKING_STATUS_KO}}") {
                                            textForModal += "<a class='btn btn-primary univaq_button' href='"+ "{{URL::to('/repeat')}}/" + result[0].repeats[x].id + "'><span class='glyphicon glyphicon-pencil univaq_menu_span' aria-hidden='true'></span></a>";
                                        }
                                    @endif
                                    textForModal += "</p>";
                                    textForModal += "</div>";
                                    textForModal += "<hr>";
                                }

                                $('#modalBody').html(textForModal);
                                $('#myModal').modal('show');
                            },

                            error : function(err) {
                                console.log(err);
                            }
                        });

                        return false;

                    }

                });

            });

            function inspectBooking(idRepeat) {

                var data = {'idRepeat' : idRepeat};

                $.ajax({

                    url: "{{URL::to('/insert-request-check')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function() {
                        $('#myModal').modal('hide');
                        $("#message-success-check").fadeIn('fast').delay(1000).fadeOut('fast');
                    },
                    error: function() {
                        $('#myModal').modal('hide');
                        $("#message-danger-check").fadeIn('fast').delay(1000).fadeOut('fast');
                    },

                });

            }

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
                $('#calendar').fullCalendar('option', 'locale', locale);
            }

        </script>

    @endsection
