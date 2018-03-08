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
<!--            <script>
                window.Laravel = <?php echo json_encode([
                    'csrfToken' => csrf_token(),
                ]); ?>
            </script>-->
            <script>
                $( function() {
                    $( ".datepicker" ).datepicker({
                            dateFormat: 'yy-mm-dd',
                            showAnim  : "drop"
                        });
                });
            </script>

            <!-- Gestione X-CSRF-Token per chiamata Ajax -->
            <script type="text/javascript">
                $.ajaxSetup({
                   headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
                });

                $(document).ready(function() {

                      $.ajax({
                          url: "{{URL::to('/manage-badge')}}",
                          type: 'POST',
                          dataType: 'json',
                          success : function(result) {
                              $("#real-time-badge").text(result);
                          },
                          error : function(result) {
                              console.log(result);
                          }
                      });

                });

            </script>
    </head>

    <body>

          <div class="container-liquid">

              <!-- Sezione Menu -->
              @include('layouts.layout-menu')

              <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-10">

                            <!-- Gestione centralizzata messaggi informativi -->
                            @include('layouts.message')

                            <!-- Corpo della pagina -->
                            @yield('content')

                            <!-- Footer pagina -->
                            @include('layouts.layout-footer')

                        </div>
                    <div class="col-md-1"></div>
                  </div>
                </div>
          </div>

    </body>

</html>
