<html lang="it">

    <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <meta name="description" content="{{ trans('messages.home_meta_description') }}">
            <meta name="author" content="Davide De Innocentis">

            <link rel="icon" href="{{URL::asset('lib/images/favicon.jpg')}}">

            <title>{{ trans('messages.home_title') }}</title>

            <!-- Caricamento librerie -->
            @include('layouts.layout-libs')
            
            <!-- CSRF Token -->
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <script>
                window.Laravel = <?php echo json_encode([
                    'csrfToken' => csrf_token(),
                ]); ?>
            </script>
            <script>
                $( function() {
                    $( ".datepicker" ).datepicker({
                            dateFormat: 'yy-mm-dd',
                            showAnim  : "drop"
                        });
                });
            </script>
    </head>

    <body>      
            <div class="container">
                <div class="container-fluid">

                    <!-- Sezione Menu -->
                    @include('layouts.layout-menu')
                    
                    <!-- Gestione centralizzata messaggi informativi -->
                    @include('layouts.message')
                    
                    <!-- Corpo della pagina -->
                    @yield('content')

                    <!-- Footer pagina -->
                    @include('layouts.layout-footer')

                </div>
            </div>
    </body>
    
</html>
