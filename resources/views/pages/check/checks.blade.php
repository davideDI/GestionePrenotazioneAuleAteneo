@extends('layouts.layout')
    @section('content')
    
        <div class="row">
            <div class="col-md-2">
                <legend>{{ trans('messages.check_title') }}</legend>
            </div>
            <div class="col-md-10">
                @if(empty($checkList))
                
                    <p>Nessun elemento da visualizzare</p>
                
                @else
                
                    <table class="table table-hover">

                        <thead>
                            <th>{{ trans('messages.check_num_students') }}</th>
                            <th>{{ trans('messages.check_exp_students') }}</th>
                            <th>{{ trans('messages.booking_capacity') }}</th>
                            <th>{{ trans('messages.booking_date_hour_start') }}</th>
                            <th>{{ trans('messages.booking_date_hour_end') }}</th>
                            <th>{{ trans('messages.booking_date_resource') }}</th>
                        </thead>
                        
                        <tbody>
                            @foreach($checkList as $check)
                                <tr id="{{ $check->id }}">
                                    <td>{{ $check->real_num_students }}</td>
                                    <td>{{ $check->repeat->booking->num_students }}</td>
                                    <td>{{ $check->repeat->booking->resource->capacity }}</td>
                                    <td>{{ $check->repeat->event_date_start }}</td>
                                    <td>{{ $check->repeat->event_date_end }}</td>
                                    <td>{{ $check->repeat->booking->resource->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                
                @endif
            </div>
        </div>
        
    @endsection
