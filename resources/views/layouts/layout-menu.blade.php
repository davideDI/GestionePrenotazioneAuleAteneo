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
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home<span class="sr-only">(current)</span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Vista
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="#">Giornaliera</a></li>
            <li><a href="#">Settimanale</a></li>
            <li><a href="#">Mensile</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Cerca...">
        </div>
        <button type="submit" class="btn btn-default">Ricerca Veloce</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-print"></span>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="#">Report</a></li>
            <li><a href="#">Stampa</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-search"></span>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="#">Aiuto</a></li>
            <li><a href="#">Aule</a></li>
            <li><a href="#">Cerca Aule</a></li>
          </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" href="#" data-toggle="dropdown"><span class="glyphicon glyphicon-log-in"></span> Login</a>
                <div class="dropdown-menu" style="padding: 15px; padding-bottom: 10px;">
                    <form class="form-horizontal"  method="post" accept-charset="UTF-8">
                        <input id="sp_uname" class="form-control marginBottom5px" type="text" name="sp_uname" placeholder="Username.." />
                        <input id="sp_pass" class="form-control marginBottom5px" type="password" name="sp_pass" placeholder="Password.."/>
                        <input class="btn btn-primary" type="submit" name="submit" value="Login" />
                    </form>
                </div>
	</li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>