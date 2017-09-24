@extends('layouts.layout')
    @section('content')
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3"></div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h4>{{ trans('messages.common_login_text') }}</h4>
                <hr>
                <form class="form-inline"  method="post" action="{{ url('/login') }}" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            
                            <label for="username">Username</label>
                            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="username.." required autofocus="">

                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                                <script>
                                    $("#dropdown_login_error").addClass("dropdown open");
                                </script>
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label for="password">Password</label>
                            <input id="password" type="password" class="form-control" name="password" placeholder="password.." required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                <script>
                                    $("#dropdown_login_error").addClass("dropdown open");
                                </script>
                            @endif
                        </div>
                    </div>

                    <div style="margin-top: 10px;" class="text-center">
                        <input class="btn btn-primary" type="submit" name="submit" value="Login" />
                    </div>
                </form>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3"></div>
    @endsection
