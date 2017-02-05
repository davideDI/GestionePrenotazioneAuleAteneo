<html lang="it">

    <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <meta name="description" content="{{ trans('messages.home_meta_description') }}">
            <meta name="author" content="Davide De Innocentis">

            <link rel="icon" href="{{URL::to('lib/images/favicon.jpg')}}">

            <title>{{ trans('messages.home_title') }}</title>

            <!-- Caricamento librerie -->
            @include('layouts.layout-libs')

    </head>

    <body>      
            <div class="container">
                <div class="container-fluid">

                    <!-- Sezione Menu -->
                    @include('layouts.layout-menu')
                    
                    <!-- Corpo della pagina -->
                    @yield('content')

                    <!-- Footer pagina -->
                    @include('layouts.layout-footer')

                </div>
            </div>
    </body>
    
</html>
