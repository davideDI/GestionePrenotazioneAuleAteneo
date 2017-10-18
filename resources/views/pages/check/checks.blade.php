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
                            @if(Session::has('ruolo') && Session::get('ruolo') == \App\TipUser::ROLE_INQUIRER)
                            <th></th>
                            @else
                                <td></td>
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
                                    @if(Session::has('ruolo') && Session::get('ruolo') == \App\TipUser::ROLE_INQUIRER
                                        &&
                                    $check->tip_survey_status_id == 1)
                                        <td>
                                            <a href="#" onclick="openModalForUpdate({{$check->id}})">
                                                <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                                            </a>
                                        </td>
                                    @else
                                        <td></td>
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
                        <form method="POST" id="checkForm" action="{{url('check')}}">
                            
                            <div id="modalBody" class="modal-body">
                                
                                {{ csrf_field() }}
                                <input type="hidden" id="survey_hidden_id" name="id" value="">
                                
                                <div class="form-group row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <label for="real_num_students">{{ trans('messages.check_num_students') }}</label>
                                            <span id="check_real_num_students_error" style="display: none" class="label label-danger">
                                                <strong>{{ trans('messages.check_real_num_students_error') }}</strong>
                                            </span>
                                        <input class="form-control" id="real_num_students" name="real_num_students" type="number" min="0">
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <label for="note">{{ trans('messages.booking_note') }}</label>
                                        <textarea class="form-control" id="note" name="note" maxlength="150"></textarea> 
                                    </div>
                                    <div class="col-md-2"></div>    
                                </div>    
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="validationCheckInput">{{ trans('messages.common_save') }}</button>
                                <button type="button" class="btn btn-default" id="buttonCloseModal" data-dismiss="modal">{{ trans('messages.common_close') }}</button>
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
        
        $("#validationCheckInput").click(function(event) {
            
            event.preventDefault();
            
            var real_num_students = $('#real_num_students').val();
                       
            if(real_num_students == 0) {
                $('#check_real_num_students_error').show();
            }
            
            else {
                $('#checkForm').submit();
            }
            
        });
        
        $("#buttonCloseModal").click(function(event) {
            $('#check_real_num_students_error').hide();
        });
            
    </script>
        
    @endsection
