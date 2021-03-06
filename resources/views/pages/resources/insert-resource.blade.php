@extends('layouts.layout')
    @section('content')

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h3>{{ trans('messages.manage_resource_resource_title')}}</h3>
                <hr>
                
                {!! Form::model($resource, ['url' => '/insert-resource', 'method' => 'post']) !!}
                    <div class="form-group row">
                        <div class="col-md-6">
                            {!! Form::label('name', trans('messages.common_name')); !!}
                            @if ($errors->has('name'))
                                <span class="label label-danger">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                            {!! Form::text('name', '', ['class' => 'form-control', 'placeholder' => trans('messages.common_name')]); !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::label('description', trans('messages.common_description')); !!}
                            @if ($errors->has('description'))
                                <span class="label label-danger">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                            {!! Form::text('description', '', ['class' => 'form-control', 'placeholder' => trans('messages.common_description')]); !!}
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
                            {!! Form::number('capacity', '', ['class' => 'form-control', 'placeholder' => trans('messages.booking_capacity'), 'min' => '0']); !!}
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
                            {!! Form::number('network', '', ['class' => 'form-control', 'placeholder' => trans('messages.booking_network'), 'min' => '0']); !!}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            {!! Form::label('note', trans('messages.booking_note')); !!}
                            {!! Form::textarea('note', '', ['class' => 'form-control', 'placeholder' => trans('messages.booking_note')]); !!}
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
                        <div class="col-md-6">
                            {!! Form::submit( trans('messages.common_save'), ['class' => 'btn btn-primary univaq_button'] ) !!}
                        </div>
                    </div>
                {!! Form::close() !!}

            </div>
            <div class="col-md-2"></div>
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
        </script>

    @endsection
