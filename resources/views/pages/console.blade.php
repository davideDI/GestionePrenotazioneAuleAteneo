@extends('layouts.layout')
    @section('content')
        
        <div class="row">
            
            <div class="col-md-2">
                <legend>{{ trans('messages.home_console') }}</legend>
                
                <!-- Sezione prenotazioni richieste -->
                <div class="row">
                    <div id="requestedBookings" class="col-md-12">
                        <img src="{{URL::asset('lib/images/loading.gif')}}" width="100" height="70" style="margin-left: 20%;" alt="loading">
                    </div>
                </div>
                
                <hr>
                
                <!-- Sezione prenotazioni in lavorazione -->
                <div class="row">
                    <div id="workingBookings" class="col-md-12">
                        <img src="{{URL::asset('lib/images/loading.gif')}}" width="100" height="70" style="margin-left: 20%;" alt="loading">
                    </div>
                </div>
                
                <hr>
                
                <!-- Sezione prenotazioni respinte -->
                <div class="row">
                    <div id="rejectedBookings" class="col-md-12">
                        <img src="{{URL::asset('lib/images/loading.gif')}}" width="100" height="70" style="margin-left: 20%;" alt="loading">
                    </div>
                </div>
                
                <hr>
                
                <!-- Sezione prenotazioni accolte -->
                <div class="row">
                    <div id="quequedBookings" class="col-md-12">
                        <img src="{{URL::asset('lib/images/loading.gif')}}" width="100" height="70" style="margin-left: 20%;" alt="loading">
                    </div>
                </div>
            </div>
            
            <div class="col-md-10">

                @if(count($groups) == 0)
                    {{ trans('messages.console_no_groups') }}
                @else
                    <ul class="nav nav-tabs">
                        @for ($i = 0; $i < count($groups); $i++)
                            @if($i == 0)
                                <li id="{{$groups[$i]->id}}" role="presentation" class="groupTab active"><a href="#">{{$groups[$i]->name}}</a></li>
                            @else
                                <li id="{{$groups[$i]->id}}" role="presentation" class="groupTab"><a href="#">{{$groups[$i]->name}}</a></li>
                            @endif
                        @endfor
                    </ul>
                @endif
                
                <div class="table-responsive" id="content" style="margin-top: 10px">
                    <img src="{{URL::asset('lib/images/loading.gif')}}" width="100" height="70" style="margin-left: 35%; margin-top: 20%;" alt="loading">
                </div>
                
            </div>
            
        </div>
    
        <script type="text/javascript">
            
            $(window).on('load', function() {
                var idItemLoaded = $(".active").attr("id");
                getBookings(idItemLoaded);
                searchBookingsByIdStatus(1);
                searchBookingsByIdStatus(2);
                searchBookingsByIdStatus(3);
                searchBookingsByIdStatus(4);
            });
            
            $(".groupTab").click(function() {
                $(".groupTab").removeClass("active");
                var idItemSelected = $(this).attr("id");
                $("#"+idItemSelected).addClass("active");
                getBookings(idItemSelected);
            }); 
            
            function searchBookingsByIdStatus(idStatus) {
                
                var data = {'id_status': idStatus};
                
                $.ajax({

                    url: "{{URL::to('/search-bookings-by-status')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function(bookings) {
                        
                        var txt = "";
                        var divToAppend = "";
                        switch (idStatus) {
                            case 1:
                                txt += "{{ trans('messages.console_booking_request') }}";
                                divToAppend += "#requestedBookings";
                                break;
                            case 2:
                                txt += "{{ trans('messages.console_booking_working') }}";
                                divToAppend += "#workingBookings";
                                break;
                            case 3:
                                txt += "{{ trans('messages.console_booking_ok') }}";
                                divToAppend += "#quequedBookings";
                                break;
                            case 4:
                                txt += "{{ trans('messages.console_booking_ko') }}";
                                divToAppend += "#rejectedBookings";
                                break;
                        }
                        var result = "<h4>" + txt + "</h4>";
                        result += "<p>";
                        if(bookings.length > 0) {
                            result += "{{ trans('messages.console_booking_there_are') }}";
                            result += bookings.length + " ";
                        } else {
                            result += "{{ trans('messages.console_booking_there_arent') }}";
                        }
                        result += txt;
                        result += "</p>";
                        $(divToAppend).html(result);
                        
                    },
                    error: function() {
                        console.log("console.balde.php - search Bookings By Id Status : ajax error");
                    }

                });
                
            }
            
            function getBookings(id_group) {
            
                var data = {'id_group': id_group};
                $.ajax({

                    url: "{{URL::to('/bookings')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function(bookings) {
                        var result = "<table class='table table-hover'>";
                        result += "<thead>";
                            result += "<th>{{trans('messages.common_title')}}</th>";
                            result += "<th>{{trans('messages.common_description')}}</th>";
                            result += "<th>{{trans('messages.booking_date_day_start')}}</th>";
                            result += "<th>{{trans('messages.booking_date_day_end')}}</th>";
                            result += "<th>{{trans('messages.booking_date_resource')}}</th>";
                            result += "<th></th>";
                        result += "</thead>";
                        result += "<tbody>";
                        for(var j=0; j < bookings.length; j++) {
                            for(var k=0; k < bookings[j].repeats.length; k++) {
                                result += "<tr id='"+bookings[j].id+"'>";
                                    result += "<td>";
                                        result += bookings[j].name;
                                    result += "</td>";
                                    result += "<td>";
                                        result += bookings[j].description;
                                    result += "</td>";
                                    result += "<td>";
                                        result += moment(bookings[j].repeats[k].event_date_start).format("DD-MM-YYYY HH:mm:ss");
                                    result += "</td>";
                                    result += "<td>";
                                        result += moment(bookings[j].repeats[k].event_date_end).format("DD-MM-YYYY HH:mm:ss");
                                    result += "</td>";
                                    result += "<td>";
                                        result += bookings[j].resource.name;
                                    result += "</td>";
                                    result += "<td>";
                                        result += "<a href='#' onclick='confirmBooking(" + bookings[j].repeats[k].id + ")'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></a>";
                                        result += "&nbsp;&nbsp;";
                                        result += "<a href='#' onclick='rejectBooking(" + bookings[j].repeats[k].id + ")'><span class='glyphicon glyphicon-remove' aria-hidden='true'></a>";
                                    result += "</td>";
                                result += "</tr>";
                            }
                        }
                        result += "</tbody>";
                        result += "</table>";
                        $("#content").html(result);
                    },
                    error: function(e) {
                        console.log("console.balde.php - search bookings by id group : ajax error");
                    }

                });
            
            }
            
            function confirmBooking(idRepeat) {
            
                var data = {'id_repeat': idRepeat};
                $.ajax({

                    url: "{{URL::to('/confirm-booking')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function() {
                        var elementToChange = "#"+idRepeat;
                        $(elementToChange).addClass("collapse out"); 
                        searchBookingsByIdStatus(1);
                        searchBookingsByIdStatus(2);
                        searchBookingsByIdStatus(3);
                        $("#message-success").fadeIn('fast').delay(1000).fadeOut('fast');
                    },
                    error: function(e) {
                        console.log(e);
                        console.log("console.balde.php - confirmBooking : ajax error");
                    }

                });
            
            }
            
            function rejectBooking(idBooking) {
            
                var data = {'id_booking': idBooking};
                $.ajax({

                    url: "{{URL::to('/reject-booking')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function() {
                        var elementToChange = "#"+idBooking;
                        $(elementToChange).addClass("collapse out"); 
                        searchBookingsByIdStatus(1);
                        searchBookingsByIdStatus(2);
                        searchBookingsByIdStatus(4);
                        $("#message-danger").fadeIn('fast').delay(1000).fadeOut('fast');
                    },
                    error: function(e) {
                        console.log(e);
                        console.log("console.balde.php - rejectBooking : ajax error");
                    }

                });
            
            }
                
        </script>
        
    @endsection
