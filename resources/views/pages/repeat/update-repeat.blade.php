@extends('layouts.layout')
    @section('content')

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h3>{{ trans('messages.common_update_repeat')}}</h3>

                {!! Form::model($repeat, ['url' => '/update-repeat', 'method' => 'post']) !!}

                {{ Form::hidden('id', $repeat->id) }}
                    <div class="form-group row">
                        <div class="col-md-6">
                            @if ($errors->has('event_date_start'))
                                <span class="label label-danger">
                                    <strong>{{ $errors->first('event_date_start') }}</strong>
                                </span>
                            @endif
                            <div id="event_date_start" name="event_date_start" class="input-append date datetimepicker1">
                                <div class="row">
                                    <div class="col-md-1">
                                        <span class="add-on">
                                            <i style="margin: 7;" data-time-icon="glyphicon glyphicon-time" data-date-icon="glyphicon glyphicon-calendar">
                                            </i>
                                        </span>
                                    </div>
                                    <div class="col-md-11">
                                        <input data-format="dd-MM-yyyy hh:mm" class="form-control" id="event_date_start_input" name="event_date_start" value="{{ $repeat->event_date_start }}" type="text"></input>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            @if ($errors->has('event_date_end'))
                                <span class="label label-danger">
                                    <strong>{{ $errors->first('event_date_end') }}</strong>
                                </span>
                            @endif
                            <div id="event_date_end" class="input-append date datetimepicker1">
                                <div class="row">
                                    <div class="col-md-1">
                                        <span class="add-on">
                                            <i style="margin: 7;" data-time-icon="glyphicon glyphicon-time" data-date-icon="glyphicon glyphicon-calendar">
                                            </i>
                                        </span>
                                    </div>
                                    <div class="col-md-11">
                                        <input data-format="dd-MM-yyyy hh:mm" class="form-control" id="event_date_end_input" name="event_date_end" value="{{ $repeat->event_date_end }}" type="text"></input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="form-group row">

                    <div class="col-md-8">
                        {!! Form::label('tip_booking_status_id', trans('messages.repeat_status_booking')); !!}
                        @if ($errors->has('tip_booking_status_id'))
                            <span class="label label-danger">
                                <strong>{{ $errors->first('tip_booking_status_id') }}</strong>
                            </span>
                        @endif
                        {!! Form::select(
                            'tip_booking_status_id',
                            $listOfTipBookingStatus,
                            null,
                            ['class' => 'listOfTipBookingStatus',
                             'style' => 'width: 70%']
                        ); !!}

                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-md-2">
                        {!! Form::submit( trans('messages.common_save'), ['class' => 'btn btn-primary univaq_button'] ) !!}
                    </div>
                </div>

            </div>
            <div class="col-md-2"></div>
        </div>

        <script type="text/javascript">

            $(function() {
                $('.datetimepicker1').datetimepicker({
                    language: 'pt-BR'
                });
            });

            $(document).ready(function() {
                $(".listOfTipBookingStatus").select2({

                });
            });

        </script>

    @endsection
