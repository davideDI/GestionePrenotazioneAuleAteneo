@extends('layouts.layout')
    @section('content')
        
        <div class="row">
            
            <div class="col-md-2"></div>
            
            <div class="col-md-8">
                @foreach($bookings as $booking)

                    {{$booking->name}}

                @endforeach
                
            </div>
            
            <div class="col-md-2"></div>
            
        </div>
    
        <div class="row">
            
            <div class="col-md-2"></div>
            
            <div class="col-md-8">
                {{ $bookings->links() }}
            </div>
            
            <div class="col-md-2"></div>
            
        </div>
    
    @endsection
