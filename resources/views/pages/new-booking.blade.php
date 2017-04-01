@extends('layouts.layout')
    @section('content')
        
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h3>Inserisci una nuova prenotazione</h3>
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
                    <div class="form-group row">
                    <!-- Event : data inizio evento -->
                        <div class="col-md-6">
                            <label for="booking_date_day_start">{{ trans('messages.booking_date_day_start') }}</label>
                            <input id="booking_date_day_start" type="text" class="form-control datepicker" name="booking_date_day_start" value="" placeholder="2017-02-21" required >
                        </div>
                    <!-- Event : data fine evento -->
                        <div class="col-md-6">
                            <label for="booking_date_day_end">{{ trans('messages.booking_date_day_end') }}</label>
                            <input id="booking_date_day_end" type="text" class="form-control datepicker" name="booking_date_day_end" value="" placeholder="2017-02-21" required >
                        </div>
                    </div>
                    
                    <div class="form-group row">
                    <!-- Event : ora inizio evento -->
                        <div class="col-md-6">
                            <label for="booking_date_hour_start">{{ trans('messages.booking_date_hour_start') }}</label>
                            <input id="booking_date_hour_start" type="text" class="form-control" name="booking_date_hour_start" value="" placeholder="10:30" required >
                        </div>
                    <!-- Event : ora fine evento -->
                        <div class="col-md-6">
                            <label for="booking_date_hour_end">{{ trans('messages.booking_date_hour_end') }}</label>
                            <input id="booking_date_hour_end" type="text" class="form-control" name="booking_date_hour_end" value="" placeholder="12:30" required >
                        </div>
                    </div>
                    
                    <div class="form-group row">
                    <!-- Booking : id group -->
                        <div class="col-md-6">
                            <label for="idGroup">{{ trans('messages.booking_date_group') }}</label>
                            <select id="groupSelect" name="groupSelect" class="listOfGroupsItems" style="width: 70%">
                                <option></option>
                                @foreach($groupsList as $group)
                                    <option value="{{$group->id}}">
                                        {{$group->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    <!-- Booking : id risorsa -->
                        <div class="col-md-6">
                            <label for="idresource">{{ trans('messages.booking_date_resource') }}</label>
                            <select id="resourceSelect" name="resourceSelect" class="listOfResourcesItems" style="width: 70%">
                                <option></option>
                                @foreach($resourceList as $resource)
                                    <option value="{{$resource->id}}">
                                        {{$resource->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        {{ trans('messages.common_save') }}
                    </button>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
        
        <!-- Select 2 -->
        <script type="text/javascript">
            $(document).ready(function() {
              $(".listOfGroupsItems").select2({
                  placeholder: "{{ trans('messages.booking_date_select_group') }}"
              });
            });
            
            $(document).ready(function() {
              $(".listOfResourcesItems").select2({
                  placeholder: "{{ trans('messages.booking_date_select_resource') }}"
              });
            });
        </script>
        
    @endsection