@extends('layouts.layout')
    @section('content')
    
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h3>{{ trans('messages.manage_resource_resource_title')}}</h3>
                
                {!! Form::model($group, ['url' => '/update-group', 'method' => 'post']) !!} 
                
                {{ Form::hidden('id', $group->id) }}
                    <div class="form-group row">
                        <div class="col-md-6">
                            {!! Form::label('name', trans('messages.common_name')); !!}
                            {!! Form::text('name', $group->name, ['class' => 'form-control', 'placeholder' => trans('messages.common_name')]); !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::label('description', trans('messages.common_description')); !!}
                            {!! Form::text('description', $group->description, ['class' => 'form-control', 'placeholder' => trans('messages.common_description')]); !!}
                        </div>
                    </div>
                
                    <div class="form-group row">
                    <!-- Resource : tip_resource -->
                        <div class="col-md-6">
                            {!! Form::label('tip_group_id', trans('messages.manage_resource_tip_group_title')); !!}

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
                        <div class="col-md-9"></div>
                        <div class="col-md-1">
                                {!! Form::submit( trans('messages.common_save'), ['class' => 'btn btn-primary'] ) !!}
                            {{ Form::close() }}
                        </div>
                        <div class="col-md-1">
                            {!! Form::open(['url' => ['/group',$group->id], 'method' => 'delete', 'id' => 'deleteGroupForm']) !!} 
                                {!! Form::submit( trans('messages.common_delete'), ['id' => 'deleteGroupButton', 'class' => 'btn btn-danger'] ) !!}
                            {!! Form::close() !!}                    
                        </div>
                    </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    
        <!-- Modal for confirm action -->
        <div class="modal fade" id="modalPreventDefaultGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                        <button id="deleteGroupButtonYES" type="button" class="btn btn-danger" >{{ trans('messages.common_confirm') }}</button>
                        <button id="deleteGroupButtonNO" type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('messages.common_close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    
        <script type="text/javascript">
            
            $(document).ready(function() {
                $(".listOfTipGroupItems").select2({
                    //parameter
                });
            });
            
            $("#deleteGroupButton").click(function(event) {
                event.preventDefault();
                $('#modalPreventDefaultGroup').modal('show');
            });
            
            $("#deleteGroupButtonYES").click(function() {
                $("#deleteGroupForm").submit();
            });
            
            $("#deleteGroupButtonNO").click(function() {
                $('#modalPreventDefaultGroup').modal('hide');
            });
            
        </script>
    
    @endsection
