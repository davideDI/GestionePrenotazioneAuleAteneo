@extends('layouts.layout')
    @section('content')

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                
                <h3>{{ trans('messages.manage_resource_group_update_title')}}</h3>
                
                    {!! Form::model($acl, ['url' => '/acl', 'method' => 'post']) !!} 

                        {{ Form::hidden('id', $acl->id) }}
                
                        <!-- Acl : cn -->
                        <div class="form-group row">
                            <div class="col-md-10">
                                {!! Form::label('email', trans('messages.acl_cn')); !!}
                                {!! Form::text('cn', $acl->user->cn, ['class' => 'form-control', 'readonly', 'placeholder' => trans('messages.acl_cn')]); !!}
                            </div>
                        </div>

                        <!-- Acl : email -->
                        <div class="form-group row">
                            <div class="col-md-10">
                                {!! Form::label('email', trans('messages.acl_email')); !!}
                                {!! Form::text('email', $acl->user->email, ['class' => 'form-control', 'readonly', 'placeholder' => trans('messages.acl_email')]); !!}
                            </div>
                        </div>

                        <div class="form-group row">
                        <!-- Acl : group id -->
                            <div class="col-md-10">
                                {!! Form::label('group_id', trans('messages.booking_date_group')); !!}
                                <select id="group_id" 
                                    class="listOfGroupItems" 
                                    style="width: 70%">
                                    <option></option>
                                    @foreach($listOfGroups as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                        <!-- Acl : tip user id -->
                            <div class="col-md-10">
                                {!! Form::label('tip_user_id', trans('messages.acl_tip_user')); !!}
                                @if ($errors->has('tip_user_id'))
                                    <span class="label label-danger">
                                        <strong>{{ $errors->first('tip_user_id') }}</strong>
                                    </span>
                                @endif
                                {!! Form::select(
                                        'tip_user_id', 
                                        $listOfTipUser, 
                                        $acl->user->tip_user_id, 
                                        ['class' => 'listOfTipUserItems',
                                         'style' => 'width: 70%']
                                    ); !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <!-- Acl : enable access -->
                            <div class="col-md-10">
                                {{ trans('messages.acl_enable_access') }}
                                {!! Form::checkbox('enable_access') !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <!-- Acl : enable crud -->
                            <div class="col-md-10">
                                {{ trans('messages.acl_enable_crud_title') }}
                                {{ Form::checkbox('enable_crud') }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-9"></div>
                            <div class="col-md-1">
                                    {!! Form::submit( trans('messages.common_save'), ['class' => 'btn btn-primary'] ) !!}
                                {{ Form::close() }}
                            </div>
                            <div class="col-md-1">
                                {!! Form::open(['url' => '/acl', 'method' => 'delete', 'id' => 'deleteAclForm']) !!} 
                                    {{ Form::hidden('id', $acl->id) }}
                                    {!! Form::submit( trans('messages.common_delete'), ['id' => 'deleteAclButton', 'class' => 'btn btn-danger'] ) !!}
                                {!! Form::close() !!}                    
                            </div>
                        </div>
                    
            </div>
            <div class="col-md-2"></div>
        </div>
    
        <!-- Modal for confirm action -->
        <div class="modal fade" id="modalPreventDefaultAcl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                        {{ trans('messages.acl_confirm_delete_text') }}
                    </div>
                    <div class="modal-footer">
                        <button id="deleteAclButtonYES" type="button" class="btn btn-danger" >{{ trans('messages.common_confirm') }}</button>
                        <button id="deleteAclButtonNO" type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('messages.common_close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    
        <script type="text/javascript">
            
            $(document).ready(function() {
                $(".listOfGroupItems").select2({
                });
                
                $(".listOfTipUserItems").select2({
                });
            });
            
            $("#deleteAclButton").click(function(event) {
                event.preventDefault();
                $('#modalPreventDefaultAcl').modal('show');
            });
            
            $("#deleteAclButtonYES").click(function() {
                $("#deleteAclForm").submit();
            });
            
            $("#deleteAclButtonNO").click(function() {
                $('#modalPreventDefaultAcl').modal('hide');
            });
            
        </script>
    
    @endsection
