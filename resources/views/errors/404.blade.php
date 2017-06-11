@extends('layouts.layout')
    @section('content')
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h3>{{ trans('errors.oops') }}</h3>
                <h4>{{ trans('errors.something_went_wrong') }}</h4>
                <h5>{{ trans('errors.404') }}</h5>
                <p>
                    {{ trans('errors.go_to') }}
                    <a href="{{url('/')}}"> {{ trans('errors.home') }}</a>
                </p>
            </div>
            <div class="col-md-3"></div>
        </div>
    
    @endsection
