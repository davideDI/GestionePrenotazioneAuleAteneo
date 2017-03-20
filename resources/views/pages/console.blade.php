@extends('layouts.layout')
    @section('content')
        
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <p>{{ trans('messages.home_console') }}</p>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <img class="center-block" src="{{URL::to('lib/images/work_in_progress.png')}}" >
            </div>
            <div class="col-md-3"></div>
        </div>
    
    @endsection