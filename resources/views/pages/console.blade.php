@extends('layouts.layout')
    @section('content')
        
        <div class="row">
            <div class="col-md-2">
                <legend>{{ trans('messages.home_console') }}</legend>
                <a href="{{url('/testSoap')}}">test soap</a>
            </div>
            
            <div class="col-md-7">

                <!-- Sezione prenotazioni richieste -->
                <div class="row">
                    <div class="col-md-12">
                        <legend>{{ trans('messages.console_booking_request') }}</legend>
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
                
                <!-- Sezione prenotazioni in lavorazione -->
                <div class="row">
                    <div class="col-md-12">
                        <legend>{{ trans('messages.console_booking_working') }}</legend>
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
                
                <!-- Sezione prenotazioni respinte -->
                <div class="row">
                    <div class="col-md-12">
                        <legend>{{ trans('messages.console_booking_ko') }}</legend>
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
                
                <!-- Sezione prenotazioni accolte -->
                <div class="row">
                    <div class="col-md-12">
                        <legend>{{ trans('messages.console_booking_ok') }}</legend>
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
            <div class="col-md-3"></div>
        </div>

    @endsection
