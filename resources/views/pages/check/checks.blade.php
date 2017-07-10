@extends('layouts.layout')
    @section('content')
    
        <div class="row">
            <div class="col-md-2">
                <legend>{{ trans('messages.check_title') }}</legend>
            </div>
            <div class="col-md-10">
                @if(count($checkList) == 0)
                
                    <h4 style='margin-left: 30%; margin-top: 25%; margin-bottom: 30%;'>{{ trans('messages.check_no_result') }}</h4>
                
                @else
                
                    <table class="table table-hover">

                        <thead>
                            @if(Session::has('ruolo') && Session::get('ruolo') == 'staff')
                            <th></th>
                            @endif
                            <th>{{ trans('messages.check_num_students') }}</th>
                            <th>{{ trans('messages.check_exp_students') }}</th>
                            <th>{{ trans('messages.booking_capacity') }}</th>
                            <th>{{ trans('messages.booking_date_hour_start') }}</th>
                            <th>{{ trans('messages.booking_date_hour_end') }}</th>
                            <th>{{ trans('messages.booking_date_resource') }}</th>
                        </thead>
                        
                        <tbody>
                            @foreach($checkList as $check)
                                <tr>
                                    @if(Session::has('ruolo') && Session::get('ruolo') == 'staff')
                                        <td>
                                            <a href="#" onclick="openModalForUpdate({{$check->id}})">
                                                <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                                            </a>
                                        </td>
                                    @endif
                                    <td>{{ $check->real_num_students }}</td>
                                    <td>{{ $check->repeat->booking->num_students }}</td>
                                    <td>{{ $check->repeat->booking->resource->capacity }}</td>
                                    <td>{{ $check->repeat->event_date_start }}</td>
                                    <td>{{ $check->repeat->event_date_end }}</td>
                                    <td>{{ $check->repeat->booking->resource->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                
                @endif
            </div>
            
            <!-- Modal for set information -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">{{ trans('messages.check_title_modal') }}</h4>
                        </div>
                        <form method="POST" action="{{url('check')}}">
                            
                            <div id="modalBody" class="modal-body">
                                
                                {{ csrf_field() }}
                                <input type="hidden" id="survey_hidden_id" name="id" value="">
                                
                                <div class="form-group row">
                                    <label for="real_num_students">{{ trans('messages.check_num_students') }}</label>
                                    @if ($errors->has('real_num_students'))
                                        <span class="label label-danger">
                                            <strong>{{ $errors->first('real_num_students') }}</strong>
                                        </span>
                                    @endif
                                    <input name="real_num_students" type="number" min="0">
                                </div>
                                
                                <div class="form-group row">
                                    <label for="note">{{ trans('messages.booking_note') }}</label>
                                    @if ($errors->has('note'))
                                        <span class="label label-danger">
                                            <strong>{{ $errors->first('note') }}</strong>
                                        </span>
                                    @endif
                                    <textarea name="note" maxlength="150"></textarea> 
                                </div>    
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">{{ trans('messages.common_save') }}</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('messages.common_close') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    
    <script>
    
        function openModalForUpdate(idSurvey) {
            
            $('#survey_hidden_id').attr("value", idSurvey);
            $('#myModal').modal('show');
            
        }
    
    </script>
        
    @endsection
