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
                        {!! Form::text('name', trans('messages.common_title'), ['class' => 'form-control']); !!}
                    </div>
                    <!-- Booking : description -->
                    <div class="form-group">
                        {!! Form::label('description', trans('messages.common_description')); !!}
                        {!! Form::text('description', trans('messages.common_description'), ['class' => 'form-control']); !!}
                    </div>
                    <div class="form-group row">
                    <!-- Booking : data inizio evento -->
                        <div class="col-md-6">
                            {!! Form::label('booking_date_day_start', trans('messages.booking_date_day_start')); !!}
                            {!! Form::text('booking_date_day_start', '2017-02-21', ['class' => 'form-control']); !!}
                        </div>
                    <!-- Booking : data fine evento -->
                        <div class="col-md-6">
                            {!! Form::label('booking_date_day_end', trans('messages.booking_date_day_end')); !!}
                            {!! Form::text('booking_date_day_end', '2017-02-21', ['class' => 'form-control']); !!}
                        </div>
                    </div>
                    
                    <div class="form-group row">
                    <!-- Booking : ora inizio evento -->
                        <div class="col-md-6">
                            {!! Form::label('booking_date_hour_start', trans('messages.booking_date_hour_start')); !!}
                            {!! Form::text('booking_date_hour_start', '10:30', ['class' => 'form-control']); !!}
                        </div>
                    <!-- Booking : ora fine evento -->
                        <div class="col-md-6">
                            {!! Form::label('booking_date_hour_end', trans('messages.booking_date_hour_end')); !!}
                            {!! Form::text('booking_date_hour_end', '12:30', ['class' => 'form-control']); !!}
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
        </script>
        
    @endsection
