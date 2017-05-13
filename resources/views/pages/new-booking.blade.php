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
                    <div class="form-group row">
                        <div class="col-md-6">
                            {!! Form::label('num_students', trans('messages.booking_num_students')); !!}
                            {!! Form::text('num_students', '', ['class' => 'form-control', 'placeholder' => trans('messages.booking_num_students')]); !!}
                        </div>
                        <div id="capacityRoom" class="col-md-6">
                            
                        </div>
                    </div>
                    
                    <hr>
                    
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
                                        <input data-format="dd-MM-yyyy hh:mm" class="form-control" id="event_date_start_input" name="event_date_start" type="text" placeholder="24-02-2017 12:00"></input>
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
                                        <input data-format="dd-MM-yyyy hh:mm" class="form-control" id="event_date_end_input" name="event_date_end" type="text" placeholder="24-02-2017 14:00"></input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                <!-- Repet Options -->    
                    <div class="form-group row">
                        <div class="col-md-3">
                            <input type="radio" name="repeat_event" onclick="closeDivEventRepeatDetails()" value="1" checked="checked">&nbsp;{{ trans('messages.booking_single_event') }}<br>
                        </div>
                        <div class="col-md-3">
                            <input type="radio" name="repeat_event" onclick="openDivEventRepeatDetails()" value="2">&nbsp;{{ trans('messages.booking_multiple_event') }}<br>
                        </div>
                    </div>
                
                    <div id="event_repeat_details" class="form-group row" style="display:none">
                        <div class="col-md-12">
                            <input id="day_0" type="checkbox" name="type_repeat[]" value="0" onclick="addRepeat('day_0', 'detail_day_0')">&nbsp;{{ trans('messages.booking_type_repeat_monday') }} &nbsp;&nbsp;
                            <input id="day_1" type="checkbox" name="type_repeat[]" value="1" onclick="addRepeat('day_1', 'detail_day_1')">&nbsp;{{ trans('messages.booking_type_repeat_tuesday') }} &nbsp;&nbsp;
                            <input id="day_2" type="checkbox" name="type_repeat[]" value="2" onclick="addRepeat('day_2', 'detail_day_2')">&nbsp;{{ trans('messages.booking_type_repeat_wednesday') }} &nbsp;&nbsp;
                            <input id="day_3" type="checkbox" name="type_repeat[]" value="3" onclick="addRepeat('day_3', 'detail_day_3')">&nbsp;{{ trans('messages.booking_type_repeat_thursday') }} &nbsp;&nbsp;
                            <input id="day_4" type="checkbox" name="type_repeat[]" value="4" onclick="addRepeat('day_4', 'detail_day_4')">&nbsp;{{ trans('messages.booking_type_repeat_friday') }} &nbsp;&nbsp;
                            <input id="day_5" type="checkbox" name="type_repeat[]" value="5" onclick="addRepeat('day_5', 'detail_day_5')">&nbsp;{{ trans('messages.booking_type_repeat_saturday') }}
                        </div>
                    </div>
                
                    <div id="detail_day_0" class="form-group row" style="display:none">
                        <div class="col-md-2"><b>{{ trans('messages.booking_type_repeat_monday') }}</b></div>
                        <div class="col-md-1">{{ trans('messages.booking_date_hour_start') }}</div>
                        <div class="col-md-2"><input type="time" name="detail_day_from_0" class="form-control " /></div>
                        <div class="col-md-1">{{ trans('messages.booking_date_hour_end') }}</div>
                        <div class="col-md-2"><input type="time" name="detail_day_to_0" class="form-control " /></div>
                    </div>
                
                    <div id="detail_day_1" class="form-group row" style="display:none">
                        <div class="col-md-2"><b>{{ trans('messages.booking_type_repeat_tuesday') }}</b></div>
                        <div class="col-md-1">{{ trans('messages.booking_date_hour_start') }}</div>
                        <div class="col-md-2"><input type="time" name="detail_day_from_1" class="form-control " /></div>
                        <div class="col-md-1">{{ trans('messages.booking_date_hour_end') }}</div>
                        <div class="col-md-2"><input type="time" name="detail_day_to_1" class="form-control " /></div>
                    </div>
                
                    <div id="detail_day_2" class="form-group row" style="display:none">
                        <div class="col-md-2"><b>{{ trans('messages.booking_type_repeat_wednesday') }}</b></div>
                        <div class="col-md-1">{{ trans('messages.booking_date_hour_start') }}</div>
                        <div class="col-md-2"><input type="time" name="detail_day_from_2" class="form-control " /></div>
                        <div class="col-md-1">{{ trans('messages.booking_date_hour_end') }}</div>
                        <div class="col-md-2"><input type="time" name="detail_day_to_2" class="form-control " /></div>
                    </div>
                
                    <div id="detail_day_3" class="form-group row" style="display:none">
                        <div class="col-md-2"><b>{{ trans('messages.booking_type_repeat_thursday') }}</b></div>
                        <div class="col-md-1">{{ trans('messages.booking_date_hour_start') }}</div>
                        <div class="col-md-2"><input type="time" name="detail_day_from_3" class="form-control " /></div>
                        <div class="col-md-1">{{ trans('messages.booking_date_hour_end') }}</div>
                        <div class="col-md-2"><input type="time" name="detail_day_to_3" class="form-control " /></div>
                    </div>
                
                    <div id="detail_day_4" class="form-group row" style="display:none">
                        <div class="col-md-2"><b>{{ trans('messages.booking_type_repeat_friday') }}</b></div>
                        <div class="col-md-1">{{ trans('messages.booking_date_hour_start') }}</div>
                        <div class="col-md-2"><input type="time" name="detail_day_from_4" class="form-control " /></div>
                        <div class="col-md-1">{{ trans('messages.booking_date_hour_end') }}</div>
                        <div class="col-md-2"><input type="time" name="detail_day_to_4" class="form-control " /></div>
                    </div>
                
                    <div id="detail_day_5" class="form-group row" style="display:none">
                        <div class="col-md-2"><b>{{ trans('messages.booking_type_repeat_saturday') }}</b></div>
                        <div class="col-md-1">{{ trans('messages.booking_date_hour_start') }}</div>
                        <div class="col-md-2"><input type="time" name="detail_day_from_5" class="form-control " /></div>
                        <div class="col-md-1">{{ trans('messages.booking_date_hour_end') }}</div>
                        <div class="col-md-2"><input type="time" name="detail_day_to_5" class="form-control " /></div>
                    </div>
                <!-- End Repet Options --> 
                
                <hr>
                
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
                                    [], 
                                    null, 
                                    ['class' => 'listOfResourcesItems',
                                     'style' => 'width: 70%']
                                ); !!}
                                
                        </div>
                    </div>
                    
                    <!-- Resource details -->
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ trans('messages.booking_resource_information') }}</div>
                        <div id="resourceSelected" class="panel-body" style="display: none">
                            <img src="{{URL::asset('lib/images/loading.gif')}}" width="100" height="70" style="margin-left: 45%;" alt="loading">
                        </div>
                    </div>
                    <!-- Note -->
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ trans('messages.booking_note') }}</div>
                        <div id="noteResourceSelected" class="panel-body" style="display: none">
                            <img src="{{URL::asset('lib/images/loading.gif')}}" width="100" height="70" style="margin-left: 45%;" alt="loading">
                        </div>
                    </div>
                    
                    {!! Form::submit( trans('messages.common_save'), ['class' => 'btn btn-primary'] ) !!}
                    
                {!! Form::close() !!}
            </div>
            <div class="col-md-2"></div>
        </div>
        
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
                getResources($("#group_id").val());
            });
            
            $("#resource_id").on("change", function() {
                appendGifLoad();
                getInfoResource($("#resource_id").val());
            });
            
            $("#group_id").on("change", function() {
                getResources($("#group_id").val());
            });
            
            function getResources(idGroup) {
                $("#resource_id").val(null);
                $("#resourceSelected").fadeOut('slow'); 
                $("#noteResourceSelected").fadeOut('slow'); 
                var selectedGroup = { 'idGroup' : idGroup};
                $('#resource_id').select2({
                    placeholder : "{{ trans('messages.booking_date_select_resource') }}",
                    ajax : {
                        type: 'post',
                        url: "{{URL::to('/resources')}}",
                        dataType: 'json',
                        data: selectedGroup,
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: false
                    }
                });
                                
            }
            
            function appendGifLoad() {
                
                $("#resourceSelected").fadeIn('slow'); 
                $("#noteResourceSelected").fadeIn('slow'); 
                $("#resourceSelected").html("<img src='{{URL::asset('lib/images/loading.gif')}}' width='100' height='70' style='margin-left: 45%;' alt='loading'>");
                $("#noteResourceSelected").html("<img src='{{URL::asset('lib/images/loading.gif')}}' width='100' height='70' style='margin-left: 45%;' alt='loading'>");
 
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
                       $("#noteResourceSelected").html(createHtmlForNoteResource(result));
                       $("#capacityRoom").html(setCapacityRoom(result));
                       
                    },
                    error : function() {
                        console.log("Errore recupero informazioni resource.");
                    }
                }); 
                
            }
            
            function setCapacityRoom(result) {
            
                $("#capacityRoom").fadeIn('slow');
                var text = "";
                text += "<p style='margin-top : 9%; margin-bottom : 0;'><b>" + result.capacity + " {{ trans('messages.booking_place_available') }}</b></p>";
                return text;
    
            }
            
            function createHtmlForResource(result) {
            
                var text = "";
                text += "<div class='col-md-4'>";
                text += "<p>{{trans('messages.booking_capacity')}} " + result.capacity+ "</p>";
                text += "<p>{{trans('messages.booking_room_admin_email')}} " + result.room_admin_email+ "</p>";
                text += "<p>{{trans('messages.booking_projector')}} " + getImgFromBoolean(result.projector) + "</p>";
                text += "<p>{{trans('messages.booking_screen_motor')}} " + getImgFromBoolean(result.screen_motor) + "</p>";
                text += "<p>{{trans('messages.booking_screen_manual')}} " + getImgFromBoolean(result.screen_manual) + "</p>";
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
                text += "<p>{{trans('messages.booking_audio')}} " + getImgFromBoolean(result.audio) + "</p>";
                text += "<p>{{trans('messages.booking_network')}} " + result.network+ "</p>";
                text += "</div>";
                return text;
            
            }
            
            function createHtmlForNoteResource(result) {
            
                var text = "";
                text += "<div class='col-md-4'>";
                if(result.note === '') {
                    text += "<p>{{trans('messages.booking_note_nd')}}</p>";
                } else {
                    text += "<p>" + result.note+ "</p>";
                }
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
            
            function closeDivEventRepeatDetails() {
            
                $("#event_repeat_details").fadeOut('slow'); 
                $("#event_date_start_input").attr('placeholder', '24-02-2017 12:00');
                $("#event_date_start_input").attr('data-format', 'dd-MM-yyyy hh:mm');
                $("#event_date_end_input").attr('placeholder', '24-02-2017 14:00');
                $("#event_date_end_input").attr('data-format', 'dd-MM-yyyy hh:mm');
                
                $("#detail_day_0").fadeOut('slow'); 
                $("#detail_day_1").fadeOut('slow'); 
                $("#detail_day_2").fadeOut('slow'); 
                $("#detail_day_3").fadeOut('slow'); 
                $("#detail_day_4").fadeOut('slow'); 
                $("#detail_day_5").fadeOut('slow'); 
            
            }
            
            function openDivEventRepeatDetails() {
            
                $("#event_repeat_details").fadeIn('slow'); 
                $("#event_date_start_input").attr('placeholder', '24-02-2017');
                $("#event_date_start_input").attr('data-format', 'dd-MM-yyyy');
                $("#event_date_end_input").attr('placeholder', '05-05-2017');
                $("#event_date_end_input").attr('data-format', 'dd-MM-yyyy');
                
            }
            
            function addRepeat(idDay, idDetailDay) {
                
                if($("#"+idDay)[0].checked == true) {
                    $("#" + idDetailDay).fadeIn('slow');
                } else {
                    $("#" + idDetailDay).fadeOut('slow');
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
