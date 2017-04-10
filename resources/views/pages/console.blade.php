@extends('layouts.layout')
    @section('content')
        
        <div class="row">
            <div class="col-md-3">
                <legend>{{ trans('messages.home_console') }}</legend>
            </div>
            <div class="col-md-6">
              
               @foreach($bookings as $booking)
                            {{$booking}}
                        @endforeach
            </div>
            <div class="col-md-3"></div>
        </div>

    @endsection
