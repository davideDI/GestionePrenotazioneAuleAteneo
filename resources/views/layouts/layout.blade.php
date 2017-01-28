<html lang="it">

    <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <meta name="description" content="Occupazione Aule e Laboratori - Univaq">
            <meta name="author" content="Davide De Innocentis">

            <link rel="icon" href="{{URL::to('lib/images/favicon.jpg')}}">

            <title>Occupazione Aule e Laboratori</title>

            <!-- Caricamento librerie -->
            @include('layouts.layout-libs')

    </head>

    <body>      
            <div class="container container-top">
                <div class="container">

                    <!-- Sezione Menu -->
                    @include('layouts.layout-menu')
                    
                    <!-- Corpo della pagina -->
                    @yield('content')

                    <!-- Footer pagina -->
                    @include('layouts.layout-footer')

                </div>
            </div>
    </body>
    
    <!-- Caricamento script calendario -->
    <script type="text/javascript">
    
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                // Definizione opzioni calendario
            });
        });
        
    </script>
   
</html>
