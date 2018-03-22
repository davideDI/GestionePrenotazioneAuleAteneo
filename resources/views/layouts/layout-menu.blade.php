<nav class="navbar navbar-default univaq_menu_navbar">
    <div class="container-fluid univaq_menu_div">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{URL::to('/')}}">
                <img src="{{URL::asset('lib/images/Logo_Top_Left.png')}}" width="40" style="margin-top: -13px; float:left" alt="Univaq">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <!-- Home -->
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{URL::to('/')}}">
                        <span class="univaq_menu_span">{{ trans('messages.home') }}</span>
                        <span class="sr-only univaq_menu_span"></span>
                    </a>
                </li>
            </ul>

            <!-- Parte destra menù -->
            <ul class="nav navbar-nav navbar-right">

                <!-- Cambio lingua -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-flag univaq_menu_span"></span>
                        <span class="caret univaq_menu_span"></span>
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
                        <span class="glyphicon glyphicon-print univaq_menu_span"></span>
                        <span class="caret univaq_menu_span"></span>
                    </a>
                    <ul class="dropdown-menu">
                        @if(Session::has('ruolo') && Session::get('ruolo') == \App\TipUser::ROLE_ADMIN_ATENEO)
                            <li><a href="{{URL::to('/report')}}">{{ trans('messages.home_report') }}</a></li>
                        @endif
                        <li><a href="{{URL::to('/print')}}">{{ trans('messages.home_print') }}</a></li>
                    </ul>
                </li>

                <!-- Cerca + Help -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-search univaq_menu_span"></span>
                        <span class="caret univaq_menu_span"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{URL::to('/help')}}">{{ trans('messages.home_help') }}</a></li>
                        <li><a href="{{URL::to('/search')}}">{{ trans('messages.home_search') }}</a></li>
                    </ul>
                </li>

                <!-- Login -->
                <li id="dropdown_login_error" class="dropdown">
                    @if(!Session::has('session_id'))
                        <a class="dropdown-toggle" href="{{url('/login')}}">
                            <span class="glyphicon glyphicon-log-in univaq_menu_span"></span>
                            <span class="univaq_menu_span">{{ trans('messages.home_login') }}</span>
                        </a>

                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                @if(Session::has('nome') && Session::has('cognome'))
                                    <span class="univaq_menu_span">{{ session('cognome') }} {{ session('nome') }}</span>
                                @else
                                    <span class="univaq_menu_span">Admin</span>
                                @endif
                                @if(Session::has('ruolo') && (Session::get('ruolo') == \App\TipUser::ROLE_ADMIN_DIP || Session::get('ruolo') == \App\TipUser::ROLE_ADMIN_ATENEO))
                                    <span id="real-time-badge" class="badge univaqBadge"></span>
                                @endif
                                <span class="caret univaq_menu_span"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                @if(Session::has('ruolo') && (Session::get('ruolo') == \App\TipUser::ROLE_ADMIN_DIP || Session::get('ruolo') == \App\TipUser::ROLE_ADMIN_ATENEO))
                                <li>
                                    <a href="{{ url('/console') }}">
                                        {{ trans('messages.home_console') }}
                                    </a>
                                </li>
                                @endif

                                @if(Session::has('ruolo') && Session::get('ruolo') == \App\TipUser::ROLE_ADMIN_ATENEO)
                                <li>
                                    <a href="{{ url('/acl') }}">
                                        {{ trans('messages.home_acl') }}
                                    </a>
                                </li>
                                @endif

                                @if(Session::has('ruolo') && Session::get('ruolo') == \App\TipUser::ROLE_ADMIN_ATENEO)
                                    <li><a href="{{ url('/manage-resources') }}">{{ trans('messages.home_manage_resources') }}</a></li>
                                @endif

                                @if(Session::has('ruolo') && Session::get('ruolo') == \App\TipUser::ROLE_INQUIRER)
                                <li>
                                    <a href="{{ url('/checks') }}">
                                        {{ trans('messages.home_checks') }}
                                        <span id="real-time-badge" class="badge"></span>
                                    </a>
                                </li>
                                @endif

                                <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ trans('messages.home_logout') }}
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
