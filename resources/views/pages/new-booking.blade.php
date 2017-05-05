@extends('layouts.layout')
    @section('content')
        
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h3>{{ trans('messages.booking_title')}}</h3>
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
                    <!-- Num Students -->
                    <div class="form-group">
                        {!! Form::label('num_students', trans('messages.booking_num_students')); !!}
                        {!! Form::text('num_students', '', ['class' => 'form-control', 'placeholder' => trans('messages.booking_num_students')]); !!}
                    </div>
                    <div class="form-group row">
                    <!-- Booking : data inizio evento -->
                        <div class="col-md-6">
                            {!! Form::label('event_date_start', trans('messages.booking_date_day_start')); !!}
                            <div id="event_date_start" name="event_date_start" class="input-append date datetimepicker1">
                                <div class="row">
                                    <div class="col-md-1">
                                        <span class="add-on">
                                            <i style="margin: 7;" data-time-icon="glyphicon glyphicon-time" data-date-icon="glyphicon glyphicon-calendar">
                                            </i>
                                        </span>
                                    </div>
                                    <div class="col-md-11">
                                        <input data-format="dd-MM-yyyy hh:mm" class="form-control" id="event_date_start" name="event_date_start" type="text" placeholder="24-02-2017 12:00"></input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- Booking : data fine evento -->
                        <div class="col-md-6">
                            {!! Form::label('event_date_end', trans('messages.booking_date_day_end')); !!}
                            <div id="event_date_end" class="input-append date datetimepicker1">
                                <div class="row">
                                    <div class="col-md-1">
                                        <span class="add-on">
                                            <i style="margin: 7;" data-time-icon="glyphicon glyphicon-time" data-date-icon="glyphicon glyphicon-calendar">
                                            </i>
                                        </span>
                                    </div>
                                    <div class="col-md-11">
                                        <input data-format="dd-MM-yyyy hh:mm" class="form-control" id="event_date_end" name="event_date_end" type="text" placeholder="24-02-2017 14:00"></input>
                                    </div>
                                </div>
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
                    <div class="form-group row">
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
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ trans('messages.booking_resource_information') }}</div>
                        <div id="resourceSelected" class="panel-body">
                            <img src="{{URL::asset('lib/images/loading.gif')}}" width="100" height="70" style="margin-left: 45%;" alt="loading">
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
                $(".listOfResourcesItems").select2({
                    placeholder: "{{ trans('messages.booking_date_select_resource') }}"
                });
                $(".listOfTipEventsItems").select2({
                    placeholder: "{{ trans('messages.booking_type_event') }}"
                });
                getInfoResource($("#resource_id").val());
            });
            
            $("#resource_id").on("change", function() {
                appendGifLoad();
                getInfoResource($("#resource_id").val());
            });
            
            
            function appendGifLoad() {
                $("#resourceSelected").html("<img src='{{URL::asset('lib/images/loading.gif')}}' width='100' height='70' style='margin-left: 45%;' alt='loading'>");
            }
            
            function getInfoResource(idResource) {
                
                var selectedResource = {'id_resource': idResource};
                $.ajax({
                    url : "{{URL::to('/resource')}}",
                    type: 'POST',
                    data: selectedResource,
                    dataType: "json",
                    success : function(result) {
                       $("#resourceSelected").html(createHtmlForResource(result));
                    },
                    error : function() {
                        console.log("Errore recupero informazioni resource.");
                    }
                }); 
                
            }
            
            function createHtmlForResource(result) {
            
                var text = "";
                text += "<div class='col-md-4'>";
                text += "<p>{{trans('messages.booking_capacity')}} " + result.capacity+ "</p>";
                text += "<p>{{trans('messages.booking_room_admin_email')}} " + result.room_admin_email+ "</p>";
                text += "<p>{{trans('messages.booking_projector')}} " + getImgFromBoolean(result.projector) + "</p>";
                text += "<p>{{trans('messages.booking_screen_motor')}} " + getImgFromBoolean(result.screen_motor) + "</p>";
                text += "<p>{{trans('messages.booking_screen_manual')}} " + getImgFromBoolean(result.screen_manual) + "</p>";
                text += "<p>{{trans('messages.booking_audio')}} " + getImgFromBoolean(result.audio) + "</p>";
                text += "</div>";
                text += "<div class='col-md-4'>";
                text += "<p>{{trans('messages.booking_pc')}} " + getImgFromBoolean(result.pc) + "</p>";
                text += "<p>{{trans('messages.booking_wire_mic')}} " + getImgFromBoolean(result.wire_mic) + "</p>";
                text += "<p>{{trans('messages.booking_wireless_mic')}} " + getImgFromBoolean(result.wireless_mic) + "</p>";
                text += "<p>{{trans('messages.booking_overhead_projector')}} " + getImgFromBoolean(result.overhead_projector) + "</p>";
                text += "<p>{{trans('messages.booking_visual_presenter')}} " + getImgFromBoolean(result.visual_presenter) + "</p>";
                text += "</div>";
                text += "<div class='col-md-4'>";
                text += "<p>{{trans('messages.booking_wiring')}} " + getImgFromBoolean(result.wiring) + "</p>";
                text += "<p>{{trans('messages.booking_blackboard')}} " + result.blackboard+ "</p>";
                text += "<p>{{trans('messages.booking_equipment')}} " + getImgFromBoolean(result.equipment) + "</p>";
                text += "<p>{{trans('messages.booking_note')}} " + result.note+ "</p>";
                text += "<p>{{trans('messages.booking_network')}} " + result.network+ "</p>";
                text += "</div>";
                return text;
            
            }
            
            function getImgFromBoolean(data) {
            
                if(data) {
                    return "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";
                } else {
                    return "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
                }
            
            }
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
