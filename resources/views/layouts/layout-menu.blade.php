<nav class="navbar navbar-default">
    <div class="container-fluid">
        
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <img src="{{URL::asset('lib/images/Logo_Top_Left.png')}}" width="94%" height="194%" style="margin-top: -10;" alt="Univaq">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <!-- Home -->
            <ul class="nav navbar-nav">
                <li>
                    <a href="#">
                        {{ trans('messages.home') }}
                        <span class="sr-only"></span>
                    </a>
                </li>
            </ul>
       
            <!-- Parte destra menù -->
            <ul class="nav navbar-nav navbar-right">
                
                <!-- Cambio lingua -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-flag"></span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        @foreach (Config::get('languages') as $lang => $language)
                            <li>
                                <a onclick="changeCalendarLocale({{$language}})" href="{{ route('lang.switch', $lang) }}">{{$language}}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                
                <!-- Report -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-print"></span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">{{ trans('messages.home_report') }}</a></li>
                        <li><a href="#">{{ trans('messages.home_print') }}</a></li>
                    </ul>
                </li>
        
                <!-- Cerca + Help -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-search"></span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">{{ trans('messages.home_help') }}</a></li>
                        <li><a href="#">{{ trans('messages.home_rooms') }}</a></li>
                        <li><a href="#">{{ trans('messages.home_find_rooms') }}</a></li>
                    </ul>
                </li>
        
                <!-- Login -->
                <li id="dropdown_login_error" class="dropdown">
                    @if (Auth::guest())
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-log-in"></span> 
                            {{ trans('messages.home_login') }}
                    </a>
                    <div class="dropdown-menu" style="padding: 15px; padding-bottom: 10px;">
                        <form class="form-inline"  method="post" action="{{ url('/login') }}" accept-charset="UTF-8">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="email.." required autofocus="">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        <script>
                                            $("#dropdown_login_error").addClass("dropdown open");
                                        </script>
                                    @endif
                            </div>

                            <div style="margin-top: 5px;" class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
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
                            
                            <div style="margin-top: 10px;" class="text-center">
                                <input class="btn btn-primary" type="submit" name="submit" value="Login" />
                                <a class="btn btn-primary" href="{{ url('/register') }}">Register</a>
                            </div>
                        </form>
                    </div>
                    
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                    
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>