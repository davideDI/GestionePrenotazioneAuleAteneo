@extends('layouts.layout')
    @section('content')

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h3>{{ trans('messages.manage_resource_group_title')}}</h3>
                <hr>
                
                {!! Form::model($group, ['url' => '/insert-group', 'method' => 'post']) !!}
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
                    <!-- Booking : id group -->
                        <div class="col-md-6">
                            {!! Form::label('tip_group_id', trans('messages.manage_resource_tip_group_title')); !!}
                            @if ($errors->has('tip_group_id'))
                                <span class="label label-danger">
                                    <strong>{{ $errors->first('tip_group_id') }}</strong>
                                </span>
                            @endif
                            {!! Form::select(
                                    'tip_group_id',
                                    $tipGroupList,
                                    null,
                                    ['class' => 'listOfTipGroupItems',
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
                $(".listOfTipGroupItems").select2({
                    //parameter
                });
            });
        </script>

    @endsection
