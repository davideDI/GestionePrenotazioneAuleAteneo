@extends('layouts.layout')
    @section('content')
        
        <div class="row">
            
            <div class="col-md-3">
                <legend>{{ trans('messages.home_console') }}</legend>
                
                <!-- Sezione prenotazioni richieste -->
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{ trans('messages.console_booking_request') }}</h4>
                        <p>
                            @if(count($quequedBookings) > 0)
                                {{ trans('messages.console_booking_there_are') }}{{count($quequedBookings)}}
                            @else
                                {{ trans('messages.console_booking_there_arent') }}
                            @endif
                            {{ trans('messages.console_booking_request') }}
                        </p>
                    </div>
                </div>
                
                <hr>
                
                <!-- Sezione prenotazioni in lavorazione -->
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{ trans('messages.console_booking_working') }}</h4>
                        <p>
                            @if(count($workingBookings) > 0)
                                {{ trans('messages.console_booking_there_are') }}{{count($workingBookings)}}
                            @else
                                {{ trans('messages.console_booking_there_arent') }}
                            @endif
                            {{ trans('messages.console_booking_working') }}
                        </p>
                    </div>
                </div>
                
                <hr>
                
                <!-- Sezione prenotazioni respinte -->
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{ trans('messages.console_booking_ko') }}</h4>
                        <p>
                            @if(count($rejectedBookings) > 0)
                                {{ trans('messages.console_booking_there_are') }}{{count($rejectedBookings)}}
                            @else
                                {{ trans('messages.console_booking_there_arent') }}
                            @endif
                            {{ trans('messages.console_booking_ko') }}
                        </p>
                    </div>
                </div>
                
                <hr>
                
                <!-- Sezione prenotazioni accolte -->
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{ trans('messages.console_booking_ok') }}</h4>
                        <p>
                            @if(count($confirmedBookings) > 0)
                                {{ trans('messages.console_booking_there_are') }}{{count($confirmedBookings)}}
                            @else
                                {{ trans('messages.console_booking_there_arent') }}
                            @endif
                            {{ trans('messages.console_booking_ok') }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">

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
                <div id="test"></div>
            </div>
            
        </div>
    
        <script type="text/javascript">
            
            $(window).on('load', function() {
                var idItemLoaded = $(".active").attr("id");
                
                var data = {'id_group': idItemLoaded};
                $.ajax({

                    url: "{{URL::to('/bookings')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function(e) {
                        $("#test").html("<p>"+e.name+"</p>"+"<p>"+e.description+"</p>");
                    },
                    error: function() {
                        console.log("console.balde.php - search bookings by id group : ajax error");
                    }

                });
            });
            
            $(".groupTab").click(function() {
                
                $(".groupTab").removeClass("active");
                var idItemSelected = $(this).attr("id");
                $("#"+idItemSelected).addClass("active");
                
                var data = {'id_group': idItemSelected};
                $.ajax({

                    url: "{{URL::to('/bookings')}}",
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function(e) {
                        $("#test").html("<p>"+e.name+"</p>"+"<p>"+e.description+"</p>");
                    },
                    error: function() {
                        console.log("console.balde.php - search bookings by id group : ajax error");
                    }

                });
                
            }); 
                
        </script>
        
    @endsection
