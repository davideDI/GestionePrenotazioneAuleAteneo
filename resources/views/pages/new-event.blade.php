@extends('layouts.layout')
    @section('content')
        
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                
                <form method="post" action="{{ url('/insert-booking') }}" accept-charset="UTF-8">
                    {{ csrf_field() }}

                    <!-- Event : name -->
                    <div class="form-group">
                        <label for="name">{{ trans('messages.common_title') }}</label>
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{ trans('messages.common_title') }}" required >
                    </div>
                    <!-- Event : description -->
                    <div class="form-group">
                        <label for="description">{{ trans('messages.common_description') }}</label>
                        <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" placeholder="{{ trans('messages.common_description') }}" required >
                    </div>
                    <!-- Booking : data prenotazione -->
                    <div class="form-group">
                        <label for="booking_date">{{ trans('messages.event_date_booking') }}</label>
                        <input id="booking_date" type="text" class="form-control" name="booking_date" value="" placeholder="{{ trans('messages.event_date_booking') }}" required >
                    </div>
                    <div class="form-group row">
                    <!-- Event : data inizio evento -->
                        <div class="col-md-6">
                            <label for="event_date_day_start">{{ trans('messages.event_date_day_start') }}</label>
                            <input id="event_date_day_start" type="text" class="form-control" name="event_date_day_start" value="" placeholder="03/02/2017" required >
                        </div>
                    <!-- Event : data fine evento -->
                        <div class="col-md-6">
                            <label for="event_date_day_end">{{ trans('messages.event_date_day_end') }}</label>
                            <input id="event_date_day_end" type="text" class="form-control" name="event_date_day_end" value="" placeholder="03/02/2017" required >
                        </div>
                    </div>
                    
                    <div class="form-group row">
                    <!-- Event : ora inizio evento -->
                        <div class="col-md-6">
                            <label for="event_date_hour_start">{{ trans('messages.event_date_hour_start') }}</label>
                            <input id="event_date_hour_start" type="text" class="form-control" name="event_date_hour_start" value="" placeholder="10:30" required >
                        </div>
                    <!-- Event : ora fine evento -->
                        <div class="col-md-6">
                            <label for="event_date_hour_end">{{ trans('messages.event_date_hour_end') }}</label>
                            <input id="event_date_hour_end" type="text" class="form-control" name="event_date_hour_end" value="" placeholder="12:30" required >
                        </div>
                    </div>
                    
                    <!-- Booking : id risorsa -->
                    <div class="form-group">
                        <label for="idresource">{{ trans('messages.event_date_resource') }}</label>
                        <input id="idresource" type="text" class="form-control" name="idresource" value="2" placeholder="" required >
                    </div>
                    <!-- Booking : id group -->
                    <div class="form-group">
                        <label for="idGroup">{{ trans('messages.event_date_group') }}</label>
                        <input id="idGroup" type="text" class="form-control" name="idGroup" value="5" placeholder="" required >
                    </div>
                    <button type="submit" class="btn btn-primary">
                        {{ trans('messages.common_save') }}
                    </button>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
        
    @endsection