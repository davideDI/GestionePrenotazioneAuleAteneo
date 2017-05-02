@extends('layouts.layout')
    @section('content')
        
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h3>Inserisci una nuova prenotazione</h3>
                {!! Form::model($booking, ['url' => '/new-booking', 'method' => 'post']) !!} 
                
                    <!-- Booking : name -->
                    <div class="form-group">
                        {!! Form::label('name', trans('messages.common_title')); !!}
                        {!! Form::text('name', '', ['class' => 'form-control', 'placeholder' => trans('messages.common_title')]); !!}
                    </div>
                    <!-- Booking : description -->
                    <div class="form-group">
                        {!! Form::label('description', trans('messages.common_description')); !!}
                        {!! Form::text('description', '', ['class' => 'form-control', 'placeholder' => trans('messages.common_description')]); !!}
                    </div>
                    <div class="form-group row">
                    <!-- Booking : data inizio evento -->
                        <div class="col-md-6">
                            {!! Form::label('event_date_start', trans('messages.booking_date_day_start')); !!}
                            <div id="event_date_start" name="event_date_start" class="input-append date datetimepicker1">
                                <input data-format="yyyy-MM-dd hh:mm:ss" class="form-control" id="event_date_start" name="event_date_start" type="text" placeholder="2017-02-24 12:00:00"></input>
                                <span class="add-on">
                                    <i data-time-icon="glyphicon glyphicon-time" data-date-icon="glyphicon glyphicon-calendar">
                                    </i>
                                </span>
                            </div>
                        </div>
                    <!-- Booking : data fine evento -->
                        <div class="col-md-6">
                            {!! Form::label('event_date_end', trans('messages.booking_date_day_end')); !!}
                            <div id="event_date_end" class="input-append date datetimepicker1">
                                <input data-format="yyyy-MM-dd hh:mm:ss" class="form-control" id="event_date_end" name="event_date_end" type="text" placeholder="2017-02-24 14:00:00"></input>
                                <span class="add-on">
                                <i data-time-icon="glyphicon glyphicon-time" data-date-icon="glyphicon glyphicon-calendar">
                                </i>
                              </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                    <!-- Booking : id group -->
                        <div class="col-md-6">
                            {!! Form::label('group_id', trans('messages.booking_date_group')); !!}
                            
                            {!! Form::select(
                                    'group_id', 
                                    $groupsList, 
                                    null, 
                                    ['class' => 'listOfGroupsItems',
                                     'style' => 'width: 70%']
                                ); !!}
                        </div>
                    <!-- Booking : id risorsa -->
                        <div class="col-md-6">
                            {!! Form::label('resource_id', trans('messages.booking_date_resource')); !!}
                            
                            {!! Form::select(
                                    'resource_id', 
                                    $resourceList, 
                                    null, 
                                    ['class' => 'listOfGroupsItems',
                                     'style' => 'width: 70%']
                                ); !!}
                                
                        </div>
                    </div>
                    <div class="form-group row">
                        <!-- Booking : id tip evento -->
                        <div class="col-md-6">
                            {!! Form::label('tip_event_id', trans('messages.booking_event')); !!}
                            
                            {!! Form::select(
                                    'tip_event_id', 
                                    $tipEventList, 
                                    null, 
                                    ['class' => 'listOfTipEventsItems',
                                     'style' => 'width: 70%']
                                ); !!}
                                
                        </div>
                    </div>
                    {!! Form::submit( trans('messages.common_save'), ['class' => 'btn btn-primary'] ) !!}
                    
                {!! Form::close() !!}
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
            
            $(document).ready(function() {
              $(".listOfTipEventsItems").select2({
                  placeholder: "{{ trans('messages.booking_type_event') }}"
              });
            });
            
            $("#group_id").on("change", function() {
               alert($(this).attr("id")); 
            });
        </script>
        
        <!-- Date time picker -->
        <script type="text/javascript">
            $(function() {
                $('.datetimepicker1').datetimepicker({
                    language: 'pt-BR'
                });
            });
        </script>
    @endsection
