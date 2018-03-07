@extends('layouts.layout')
    @section('content')

        <div class="row">
            <div class="col-md-3"></div>

            <div class="col-md-6">

                <h3>{{ trans('messages.acl_title_insert')}}</h3>

                @if(isset($userFinded) && $userFinded)
                    <div class="alert alert-danger" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ trans('messages.acl_user_not_found') }}
                    </div>
                @endif

                @if(!$checkSearchTrue)
                    <form method="POST" action="{{ url('/get-ldap-user-info') }}">
                        {{ csrf_field() }}
                        <div class="col-md-6">
                            <input name="cn" type="text" class="form-control" />
                        </div>
                        <div class="col-md-3">
                            <input type="submit" class="btn btn-primary univaq_button" value="{{ trans('messages.acl_check_user') }}" />
                        </div>
                    </form>
                @endif

                @if($checkSearchTrue)
                    {!! Form::model($user, ['url' => '/insert-user', 'method' => 'post']) !!}

                        {{ Form::hidden('registration_number', $user->registration_number) }}
                        {{ Form::hidden('name', $user->name) }}
                        {{ Form::hidden('surname', $user->surname) }}

                        <!-- Acl : cn -->
                        <div class="form-group row">
                            <div class="col-md-10">
                                {!! Form::label('cn', trans('messages.acl_cn')); !!}
                                {!! Form::text('cn', $user->cn, ['class' => 'form-control', 'readonly', 'placeholder' => trans('messages.acl_cn')]); !!}
                            </div>
                        </div>

                        <!-- Acl : email -->
                        <div class="form-group row">
                            <div class="col-md-10">
                                {!! Form::label('email', trans('messages.acl_email')); !!}
                                {!! Form::text('email', $user->email, ['class' => 'form-control', 'readonly', 'placeholder' => trans('messages.acl_email')]); !!}
                            </div>
                        </div>

                        <div class="form-group row">
                        <!-- Acl : group id -->
                            <div class="col-md-10">
                                {!! Form::label('group_id', trans('messages.booking_date_group')); !!}
                                @if ($errors->has('group_id'))
                                    <span class="label label-danger">
                                        <strong>{{ $errors->first('group_id') }}</strong>
                                    </span>
                                @endif
                                {!! Form::select(
                                        'group_id',
                                        $listOfGroups,
                                        null,
                                        ['class' => 'listOfGroupItems',
                                         'style' => 'width: 70%']
                                    ); !!}
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
                                        null,
                                        ['class' => 'listOfTipUserItems',
                                         'style' => 'width: 70%']
                                    ); !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <!-- Acl : enable access -->
                            <div class="col-md-10">
                                {{ trans('messages.acl_enable_access') }}
                                {{ Form::checkbox('enable_access') }}
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
                            <div class="col-md-6">
                                {!! Form::submit( trans('messages.common_save'), ['class' => 'btn btn-primary univaq_button'] ) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                @endif
            </div>

            <div class="col-md-3"></div>
        </div>

        <script type="text/javascript">

            $(document).ready(function() {
                $(".listOfGroupItems").select2({
                });

                $(".listOfTipUserItems").select2({
                });
            });

        </script>

    @endsection
