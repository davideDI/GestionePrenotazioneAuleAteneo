@extends('layouts.layout')
@section('content')

    <!-- Prima sezione : scritta benvenuto -->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <p class="text-center"><b>{{ trans('messages.home_welcome') }}</b></p>
        </div>
    </div>
    
    <!-- Prima sezione - sottosezione -->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <p class="text-center">{{ trans('messages.home_sub_section') }}</p>
        </div>
    </div>
    
    <hr>
    
    <!-- Seconda sezione : elenco gruppi edifici -->
    <div class="row">
        @foreach ($groupsList as $group)
            <div class="col-xs-4 col-sm-4 col-md-4">
                <a href="{{URL::to('/bookings', $group->id)}}">
                    <p class="text-center"><b>{{ $group->name }}</b></p>
                </a>
                <p class="text-center">{{ $group->description }}</p>
            </div>        
        @endforeach
    </div>
@endsection
