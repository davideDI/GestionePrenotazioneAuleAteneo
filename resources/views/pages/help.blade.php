@extends('layouts.layout')
    @section('content')
    
        <div class="row">
            <div class="col-md-12">
                <h4>
                    {{ trans('messages.help_contact') }}
                </h4>

                <p>
                    {{ trans('messages.help_contact_text') }}
                </p>
                <ul>
                    <li>{{ trans('messages.help_contact_list1') }}</li>
                    <li>{{ trans('messages.help_contact_list2') }}</li>
                    <li>{{ trans('messages.help_contact_list3') }}</li>
                </ul>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                <h4>
                    {{ trans('messages.help_auth') }}
                </h4>

                <p>
                    {{ trans('messages.help_auth_text') }}
                </p>
            </div>
        </div>
    
    @endsection