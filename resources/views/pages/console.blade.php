@extends('layouts.layout')
    @section('content')
        
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <p>{{ trans('messages.home_console') }}</p>
            </div>
            <div class="col-md-3"></div>
        </div>
        @foreach($bookings as $booking)
            {{$booking}}    
        @endforeach
        

    @endsection
