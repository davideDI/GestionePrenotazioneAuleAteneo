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
                <img src="{{URL::asset('lib/images/Logo_Top_Left.png')}}" width="94%" height="194%" style="margin-top: -10;" alt="profile Pic">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <!-- Home -->
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="#">
                        {{ trans('messages.home') }}
                        <span class="sr-only">(current)</span>
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
                                <a href="{{ route('lang.switch', $lang) }}">{{$language}}</a>
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
                <li class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-log-in"></span> 
                            {{ trans('messages.home_login') }}
                    </a>
                    <div class="dropdown-menu" style="padding: 15px; padding-bottom: 10px;">
                        <form class="form-horizontal"  method="post" accept-charset="UTF-8">
                            <input id="sp_uname" class="form-control marginBottom5px" type="text" name="sp_uname" placeholder="Email.." />
                            <input id="sp_pass" class="form-control marginBottom5px" type="password" name="sp_pass" placeholder="Password.."/>
                            <input class="btn btn-primary" type="submit" name="submit" value="Login" />
                        </form>
                    </div>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>