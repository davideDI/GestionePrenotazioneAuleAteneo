@extends('layouts.layout')
    @section('content')

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h3>{{ trans('messages.manage_resource_resource_update_title')}}</h3>
                <hr>
                
                {!! Form::model($resource, ['url' => '/update-resource', 'method' => 'post']) !!}

                {{ Form::hidden('id', $resource->id) }}
                    <div class="form-group row">
                        <div class="col-md-6">
                            {!! Form::label('name', trans('messages.common_name')); !!}
                            @if ($errors->has('name'))
                                <span class="label label-danger">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                            {!! Form::text('name', $resource->name, ['class' => 'form-control', 'placeholder' => trans('messages.common_name')]); !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::label('description', trans('messages.common_description')); !!}
                            @if ($errors->has('description'))
                                <span class="label label-danger">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                            {!! Form::text('description', $resource->description, ['class' => 'form-control', 'placeholder' => trans('messages.common_description')]); !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            {!! Form::label('capacity', trans('messages.booking_capacity')); !!}
                            @if ($errors->has('capacity'))
                                <span class="label label-danger">
                                    <strong>{{ $errors->first('capacity') }}</strong>
                                </span>
                            @endif
                            {!! Form::number('capacity', $resource->capacity, ['class' => 'form-control', 'placeholder' => trans('messages.booking_capacity'), 'min' => '0']); !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3">
                            {{ trans('messages.booking_projector') }}
                            {{ Form::checkbox('projector') }}
                        </div>
                        <div class="col-md-3">
                            {{ trans('messages.booking_screen_motor') }}
                            {{ Form::checkbox('screen_motor') }}
                        </div>
                        <div class="col-md-3">
                            {{ trans('messages.booking_screen_manual') }}
                            {{ Form::checkbox('screen_manual') }}
                        </div>
                        <div class="col-md-3">
                            {{ trans('messages.booking_audio') }}
                            {{ Form::checkbox('audio') }}
                        </div>
                        <div class="col-md-3">
                            {{ trans('messages.booking_pc') }}
                            {{ Form::checkbox('pc') }}
                        </div>
                        <div class="col-md-3">
                            {{ trans('messages.booking_wire_mic') }}
                            {{ Form::checkbox('wire_mic') }}
                        </div>
                        <div class="col-md-3">
                            {{ trans('messages.booking_wireless_mic') }}
                            {{ Form::checkbox('wireless_mic') }}
                        </div>
                        <div class="col-md-3">
                            {{ trans('messages.booking_overhead_projector') }}
                            {{ Form::checkbox('overhead_projector') }}
                        </div>
                        <div class="col-md-3">
                            {{ trans('messages.booking_visual_presenter') }}
                            {{ Form::checkbox('visual_presenter') }}
                        </div>
                        <div class="col-md-3">
                            {{ trans('messages.booking_wiring') }}
                            {{ Form::checkbox('wiring') }}
                        </div>
                        <div class="col-md-3">
                            {{ trans('messages.booking_equipment') }}
                            {{ Form::checkbox('equipment') }}
                        </div>
                        <div class="col-md-3">
                            {{ trans('messages.booking_blackboard') }}
                            {{ Form::checkbox('blackboard') }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            {!! Form::label('network', trans('messages.booking_network')); !!}
                            @if ($errors->has('network'))
                                <span class="label label-danger">
                                    <strong>{{ $errors->first('network') }}</strong>
                                </span>
                            @endif
                            {!! Form::number('network', $resource->network, ['class' => 'form-control', 'placeholder' => trans('messages.booking_network'), 'min' => '0']); !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            {!! Form::label('note', trans('messages.booking_note')); !!}
                            {!! Form::textarea('note', $resource->note, ['class' => 'form-control', 'placeholder' => trans('messages.booking_note')]); !!}
                        </div>
                    </div>

                    <div class="form-group row">
                    <!-- Resource : tip_resource -->
                        <div class="col-md-6">
                            {!! Form::label('tip_resource_id', trans('messages.manage_resource_tip_group_title')); !!}

                            {!! Form::select(
                                    'tip_resource_id',
                                    $tipResourceList,
                                    null,
                                    ['class' => 'listOfTipResourceItems',
                                     'style' => 'width: 70%']
                                ); !!}
                        </div>
                    <!-- Resource : group_id -->
                        <div class="col-md-6">
                            {!! Form::label('group_id', trans('messages.manage_resource_tip_group_title')); !!}

                            {!! Form::select(
                                    'group_id',
                                    $groupList,
                                    null,
                                    ['class' => 'listOfGroupItems',
                                     'style' => 'width: 70%']
                                ); !!}
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-md-9"></div>
                        <div class="col-md-1">
                                {!! Form::submit( trans('messages.common_save'), ['class' => 'btn btn-primary univaq_button'] ) !!}
                            {{ Form::close() }}
                        </div>
                        <div class="col-md-1">
                            {!! Form::open(['url' => ['/resource',$resource->id], 'id' => 'deleteResourceForm', 'method' => 'delete']) !!}
                                {!! Form::submit( trans('messages.common_delete'), ['id' => 'deleteResourceButton', 'class' => 'btn btn-danger'] ) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
            </div>
            <div class="col-md-2"></div>
        </div>

        <!-- Modal for confirm action -->
        <div class="modal fade" id="modalPreventDefaultResource" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">
                            {{ trans('messages.manage_resource_confirm_delete') }}
                        </h4>
                    </div>
                    <div id="modalBody" class="modal-body">
                        {{ trans('messages.manage_resource_confirm_delete_text') }}
                    </div>
                    <div class="modal-footer">
                        <button id="deleteResourceButtonYES" type="button" class="btn btn-danger" >{{ trans('messages.common_confirm') }}</button>
                        <button id="deleteResourceButtonNO" type="button" class="btn btn-primary univaq_button" data-dismiss="modal">{{ trans('messages.common_close') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">

            $(document).ready(function() {
                $(".listOfTipResourceItems").select2({
                    //parameter
                });

                $(".listOfGroupItems").select2({
                    //parameter
                });
            });

            $("#deleteResourceButton").click(function(event) {
                event.preventDefault();
                $('#modalPreventDefaultResource').modal('show');
            });

            $("#deleteResourceButtonYES").click(function() {
                $("#deleteResourceForm").submit();
            });

            $("#deleteResourceButtonNO").click(function() {
                $('#modalPreventDefaultResource').modal('hide');
            });

        </script>

    @endsection
