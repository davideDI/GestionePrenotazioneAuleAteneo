@extends('layouts.layout')
    @section('content')

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h3>{{ trans('messages.booking_title')}}</h3>
                <hr>
                {!! Form::model($booking, ['url' => '/new-booking', 'method' => 'post']) !!}

                    <!-- Booking : name -->
                    <div class="form-group">
                        {!! Form::label('name', trans('messages.common_title'), ['class' => 'down']); !!}
                        @if ($errors->has('name'))
                            <span class="label label-danger">
                                <strong>{{ trans('errors.field_required') }}</strong>
                            </span>
                        @endif
                        {!! Form::text('name', '', ['class' => 'form-control', 'placeholder' => trans('messages.common_title')]); !!}
                    </div>
                    <!-- Booking : description -->
                    <div class="form-group">
                        {!! Form::label('description', trans('messages.common_description')); !!}
                        @if ($errors->has('description'))
                            <span class="label label-danger">
                                <strong>{{ trans('errors.field_required') }}</strong>
                            </span>
                        @endif
                        {!! Form::text('description', '', ['class' => 'form-control', 'placeholder' => trans('messages.common_description')]); !!}
                    </div>
                    <!-- Num Students -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            {!! Form::label('num_students', trans('messages.booking_num_students')); !!}
                            @if ($errors->has('num_students'))
                                <span id="num_students_required" class="label label-danger">
                                    <strong>{{ trans('errors.field_required') }}</strong>
                                </span>
                            @endif
                            <span id="maxNumError" class="label label-danger" style="display: none">
                                <strong>{{ trans('errors.new_booking_num_max') }}</strong>
                            </span>
                            {!! Form::number('num_students', '', ['class' => 'form-control', 'placeholder' => trans('messages.booking_num_students'), 'min' => 0]); !!}
                        </div>
                        <div id="capacityRoom" class="col-md-6">

                        </div>
                    </div>

                    <hr>

                    <div class="form-group row">
                    <!-- Booking : data inizio evento -->
                        <div class="col-md-6">
                            {!! Form::label('event_date_start', trans('messages.booking_date_day_start')); !!}
                            @if ($errors->has('event_date_start'))
                                <span id="date_start_required" class="label label-danger">
                                    <strong>{{ trans('errors.field_required') }}</strong>
                                </span>
                            @endif
                            <span id="dateStartFormatError" class="label label-danger" style="display: none">
                                <strong>{{ trans('errors.new_booking_date_format') }}</strong>
                            </span>
                            @if(empty($date_start))
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
                            @else
                                <div class="row">
                                    <div class="col-md-12">
                                        <input class="form-control" id="event_date_start_input" name="event_date_start" type="text" value="{{$date_start}}" readonly="true"></input>
                                    </div>
                                </div>
                            @endif
                        </div>
                    <!-- Booking : data fine evento -->
                        <div class="col-md-6">
                            {!! Form::label('event_date_end', trans('messages.booking_date_day_end')); !!}
                            @if ($errors->has('event_date_end'))
                                <span id="date_end_required" class="label label-danger">
                                    <strong>{{ trans('errors.field_required') }}</strong>
                                </span>
                            @endif
                            <span id="dateEndFormatError" class="label label-danger" style="display: none">
                                <strong>{{ trans('errors.new_booking_date_format') }}</strong>
                            </span>
                            @if(empty($date_start))
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
                            @else
                                <div class="row">
                                    <div class="col-md-12">
                                        <input class="form-control" id="event_date_end_input" name="event_date_end" type="text" value="{{$date_end}}" readonly="true"></input>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="form-group row" style="display: none">
                             <div class="col-md-3">
                                 <input type="radio" name="repeat_event" onclick="closeDivEventRepeatDetails()" value="1" checked="checked">&nbsp;{{ trans('messages.booking_single_event') }}<br>
                             </div>
                             <!-- <div class="col-md-3">
                                 <input type="radio" name="repeat_event" onclick="openDivEventRepeatDetails()" value="2">&nbsp;{{ trans('messages.booking_multiple_event') }}<br>
                             </div> -->
                        </div>

                    </div>

                <hr>

                    <div class="form-group row">
                        @if(!empty($groupsList))
                        <!-- Booking : id group - list -->
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
                        @else
                        <!-- Booking : id group - single -->
                            <div class="col-md-6">
                                {!! Form::label('group_id', trans('messages.booking_date_group')); !!}
                                {!! Form::hidden('group_id', $group->id); !!}
                                {!! Form::text('groupName', $group->name, ['class' => 'form-control', 'style' => 'width: 60%', 'readonly']); !!}
                            </div>
                        @endif
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
                        @if(!empty($resourceList))
                        <!-- Booking : id risorsa - lista -->
                            <div class="col-md-6">
                                {!! Form::label('resource_id', trans('messages.booking_date_resource')); !!}
                                <span id="resource_id_for_repeat" class="label label-danger" style="display: none">
                                    <strong>{{ trans('messages.booking_resource_id_empty') }}</strong>
                                </span>
                                @if ($errors->has('resource_id'))
                                    <span class="label label-danger">
                                        <strong>{{ trans('errors.field_required') }}</strong>
                                    </span>
                                @endif
                                {!! Form::select(
                                        'resource_id',
                                        [],
                                        null,
                                        ['class' => 'listOfResourcesItems',
                                         'style' => 'width: 70%']
                                    ); !!}

                            </div>
                        @else
                        <!-- Booking : id risorsa - single -->
                            <div class="col-md-6">
                                {!! Form::label('resource_id', trans('messages.booking_date_resource')); !!}
                                {!! Form::text('resource_id', $resource->name, ['class' => 'form-control', 'style' => 'width: 60%', 'readonly']); !!}

                                {!! Form::hidden('flag_search_resource', true); !!}
                            </div>
                        @endif
                    <!-- Booking : materie prof -->
                        @if(Session::has('session_id') && Session::get('ruolo') == \App\TipUser::ROLE_TEACHER )
                        <div class="col-md-6">
                            {!! Form::label('teaching_id', trans('messages.booking_date_teachings')); !!}

                            {!! Form::select(
                                    'teaching_id',
                                    $listOfTeachings,
                                    null,
                                    ['class' => 'listOfTeachings',
                                     'style' => 'width: 70%']
                                ); !!}

                        </div>
                        @endif

                    </div>

                @if(Session::has('session_id') && Session::get('ruolo') == \App\TipUser::ROLE_SECRETARY)
                <div class="form-group row">

                    <!-- Booking : lista facolta -->
                        <div class="col-md-12">
                            {!! Form::label('department_id', trans('messages.booking_date_departments')); !!}

                            {!! Form::select(
                                    'department_id',
                                    $departmentList,
                                    null,
                                    ['class' => 'listOfDepartments',
                                     'style' => 'width: 90%']
                                ); !!}

                        </div>
                </div>

                <!-- Booking : lista CDS -->
                <div class="form-group row">
                    <div class="col-md-12">
                    {!! Form::label('cds_id', trans('messages.booking_date_cds')); !!}

                            {!! Form::select(
                                    'cds_id',
                                    [],
                                    null,
                                    ['class' => 'cds_id',
                                     'style' => 'width: 90%']
                                ); !!}
                    </div>
                </div>

                <!-- Booking : lista insegnamenti -->
                <div class="form-group row">
                    <div class="col-md-12">
                    {!! Form::label('subject_id', trans('messages.booking_date_subjects')); !!}

                            {!! Form::select(
                                    'subject_id',
                                    [],
                                    null,
                                    ['class' => 'js-example-basic-single subject_id ',
                                     'style' => 'width: 85%']
                                ); !!}
                    </div>
                </div>

                @endif

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

                    <div class="form-group row">
                        <div class="col-md-2">
                            {!! Form::submit(trans('messages.common_save'), ['id' => 'insert_booking_button', 'class' => 'btn btn-primary univaq_button'] ) !!}
                        </div>
                        @if(Session::has('session_id') && Session::get('ruolo') == \App\TipUser::ROLE_SECRETARY)
                            <div class="col-md-2">
                                <a href="#" class="btn btn-primary univaq_button" id="repeatEvents"> {{ trans('messages.booking_repeat_event') }}</a>
                            </div>
                        @endif
                        @if(Session::has('session_id') && Session::get('ruolo') == \App\TipUser::ROLE_STUDENT)
                        <div class="col-md-10">
                            <b>{{ trans('messages.booking_warning_student') }}</b>
                        </div>
                        @endif
                    </div>

                {!! Form::close() !!}
            </div>
            <div class="col-md-2"></div>
        </div>

        <!-- Modal for repeat event -->
            <div class="modal fade" id="repeatEventsModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">{{ trans('messages.booking_repeat_event') }}</h4>
                        </div>
                        <div class="modal-body">
                            <div id="repeatEventsBodyErrorDiv" style="display: none" class="alert alert-danger" role="alert">

                            </div>
                            <div id="repeatEventsBodySuccessDiv" style="display: none" class="alert alert-success" role="alert">

                            </div>
                            <div id="repeatEventsBody">

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="confirm_repeat_events" class="btn btn-primary">{{ trans('messages.booking_confirm_repeat') }}</button>
                            <button type="button" id="close_confirm_repeat_events" class="btn btn-default" data-dismiss="modal">{{ trans('messages.common_close') }}</button>
                        </div>
                    </div>
                </div>
            </div>

        <script type="text/javascript">

            $("#close_confirm_repeat_events").click( function() {

               $("#repeatEventsBody").html("");
               $("#repeatEventsBodyErrorDiv").html("");
               $("#repeatEventsBodyErrorDiv").hide();

               $("#repeatEventsBodySuccessDiv").html("");
               $("#repeatEventsBodySuccessDiv").hide();

            });

            $("#confirm_repeat_events").click( function () {

                var resourceId = $("#resource_id").val();

                $.ajax({

                    dataType : 'JSON',
                    data : {'resourceId' : resourceId},
                    type : 'POST',
                    url : "{{URL::to('/booking-repeat-events-confirm')}}",
                    success : function() {

                        var result = "{{ trans('messages.booking_re_confirmed_ok') }}";
                        $("#confirm_repeat_events").hide();
                        $("#repeatEventsBody").html("");
                        $("#repeatEventsBodySuccessDiv").html(result);
                        $("#repeatEventsBodySuccessDiv").show();

                    },
                    error : function(result) {

                        var errorMessage = "{{ trans('messages.booking_repeat_ko') }}";
                        $("#repeatEventsBodyErrorDiv").html(errorMessage);
                        $("#repeatEventsBodyErrorDiv").show();
                        console.log(result);

                    }

                });

            });

            $("#repeatEvents").click(function (event) {

                event.preventDefault();

                var resourceId = $("#resource_id").val();

                if(resourceId === null ) {

                    $("#resource_id_for_repeat").show();

                } else {

                    $("#resource_id_for_repeat").hide();
                    $("#confirm_repeat_events").show();

                    $.ajax({

                        dataType : 'JSON',
                        data : {'resourceId' : resourceId},
                        type : 'POST',
                        url : "{{URL::to('/booking-repeat-events')}}",
                        success : function(repeats) {
                            var result = "";

                            if(repeats.length == 0) {
                                result += "<p>{{ trans('messages.booking_no_result') }}</p>";
                                $("#confirm_repeat_events").hide();
                            } else {
                                result += "<table class='table table-hover'>";
                                    result += "<thead>";
                                        result += "<th>{{trans('messages.common_title')}}</th>";
                                        result += "<th>{{trans('messages.common_description')}}</th>";
                                        result += "<th>{{trans('messages.booking_date_day_start')}}</th>";
                                        result += "<th>{{trans('messages.booking_date_day_end')}}</th>";
                                result += "</thead>";
                                result += "<tbody>";

                                for(var j=0; j < repeats.length; j++) {

                                    result += "<tr id='"+repeats[j].id+"'>";
                                        result += "<td>";
                                            result += repeats[j].booking.name;
                                        result += "</td>";
                                        result += "<td>";
                                            result += repeats[j].booking.description;
                                        result += "</td>";
                                        result += "<td>";
                                            result += moment(repeats[j].event_date_start).format("DD-MM-YYYY HH:mm:ss");
                                        result += "</td>";
                                        result += "<td>";
                                            result += moment(repeats[j].event_date_end).format("DD-MM-YYYY HH:mm:ss");
                                        result += "</td>";
                                    result += "</tr>";

                                }
                                result += "</tbody>";
                                result += "</table>";
                            }

                            $("#repeatEventsBody").html(result);

                        },
                        error : function(result) {
                            console.log(result);
                        }

                    });

                    $('#repeatEventsModal').modal('show');

                }

            });

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
                $(".listOfTeachings").select2({
                    placeholder: "{{ trans('messages.booking_date_select_teaching') }}"
                });
                $(".listOfDepartments").select2({
                    placeholder: "{{ trans('messages.booking_date_select_department') }}"
                });
                $(".cds_id").select2({
                    placeholder: "{{ trans('messages.booking_date_select_cds') }}"
                });
                $(".subject_id").select2({
                    placeholder: "{{ trans('messages.booking_date_select_subject') }}"
                });

                @if(!empty($resourceList))
                    getResources($("#group_id").val());
                @else
                    appendGifLoad();
                    getInfoResource({{$resource->id}});
                @endif
            });

            function dateRegEx(date){
                var pattern = new RegExp("^(3[01]|[12][0-9]|0[1-9])-(1[0-2]|0[1-9])-[0-9]{4} (2[0-3]|[01]?[0-9]):([0-5]?[0-9])$");
                if (date.search(pattern)===0)
                  return true;
                else {
              	  return false;
                }
            }

            $("#insert_booking_button").on("click", function (event) {

                var capacity_room = $("[name='capacity_room']").val();
                var num_students = $("#num_students").val();

                if(parseInt(num_students) > parseInt(capacity_room)) {
                    $("#maxNumError").show();
                    $("#num_students_required").hide();
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: $(".down").offset().top
                    }, 1000);
                } else {
                    $("#maxNumError").hide();
                }

                if(!dateRegEx($("#event_date_start_input").val())) {
                    $("#date_start_required").hide();
                    $("#dateStartFormatError").show();
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: $(".down").offset().top
                    }, 1000);
                } else {
                    $("#dateStartFormatError").hide();
                }

                if(!dateRegEx($("#event_date_end_input").val())) {
                    $("#date_end_required").hide();
                    $("#dateEndFormatError").show();
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: $(".down").offset().top
                    }, 1000);
                } else {
                    $("#dateEndFormatError").hide();
                }

            });

            $("#department_id").on("change", function() {
                $("#cds_id").html("");
                $("#subject_id").html("");
                getCDSFromDepartment($("#department_id").val());
            });

            function getCDSFromDepartment(idDepartment) {
                var selectedDepartment = { 'idDepartment' : idDepartment};
                $('#cds_id').select2({
                    placeholder: "{{ trans('messages.booking_date_select_cds') }}",
                    ajax : {
                        type: 'post',
                        url: "{{URL::to('/cds')}}",
                        dataType: 'json',
                        data: selectedDepartment,
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: false
                    }
                });
            }

            $("#cds_id").on("change", function() {
                $("#subject_id").html("");
                getSubjectsFromCds($("#cds_id").val());
            });

            function getSubjectsFromCds(cds) {
                var selectedCds = { 'cds' : cds};
                $('#subject_id').select2({
                    placeholder: "{{ trans('messages.booking_date_select_subject') }}",
                    ajax : {
                        type: 'post',
                        url: "{{URL::to('/subjects')}}",
                        dataType: 'json',
                        data: selectedCds,
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: false
                    }
                });
            }

            $("#resource_id").on("change", function() {
                appendGifLoad();
                getInfoResource($("#resource_id").val());
            });

            $("#group_id").on("change", function() {
                getResources($("#group_id").val());
            });

            function getResources(idGroup) {
                $("#resource_id").html("");
                $("#resourceSelected").fadeOut('slow');
                $("#noteResourceSelected").fadeOut('slow');
                $("#capacityRoom").html("");
                var selectedGroup = { 'idGroup' : idGroup};

                $.ajax({
                    type: 'post',
                    url: "{{URL::to('/resources')}}",
                    dataType: 'json',
                    data: selectedGroup,
                }).then(function (response) {
                    $("#resource_id").select2({
                        placeholder : "{{ trans('messages.booking_date_select_resource') }}",
                        data: response,
                        cache : false
                    });
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
                text += "<input type='hidden' name='capacity_room' value='" + result.capacity + "' />";
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
