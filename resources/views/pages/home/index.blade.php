@extends('layouts.layout')
@section('content')

    <!-- Prima sezione : scritta benvenuto -->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <h3 class="text-center"><b>{{ trans('messages.home_welcome') }}</b></h3>
        </div>
    </div>

    <!-- Prima sezione - sottosezione -->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <p class="text-center">{{ trans('messages.home_sub_section') }}</p>
        </div>
    </div>
    <br>


    <!-- Seconda sezione : elenco gruppi edifici -->
    <div class="row">
        @foreach ($groupsList as $group)
            <div class="col-xs-4 col-sm-4 col-md-4 box-home">
                <div class="icon-home"></div>
                <a href="{{URL::to('/bookings', $group->id)}}" class="title-box-home">
                    <p class="text-center"><b>{{ $group->name }}</b></p>
                </a>
                <p class="text-center">{{ $group->description }}</p>
            </div>
        @endforeach
    </div>

@endsection
