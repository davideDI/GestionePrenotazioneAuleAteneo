<footer class="page-footer font-small blue pt-4 mt-4" style=" clear: both; width: 100%; background-color: #2f2f2f;color: #ffffff; padding: 10px 0px; height: 150px">
    <div class="container-fluid text-center text-md-left">
        <div class="row">
          <div class="col-md-2"></div>
            <div class="col-md-8">
              <p class="text-center" style="font-size: 16px">
                  {{ trans('messages.footer_title') }}
              </p>
              <hr>

              <p class="text-center">
                  <a href="{{URL::to('http://www.univaq.it/')}}" target="_blank" style="color: #ffffff">
                      {{ trans('messages.footer_title_univaq') }}
                  </a>
              </p>
              <p class="text-center">
                  <a href="{{URL::to('http://www.univaq.it/section.php?id=573')}}" target="_blank" style="color: #65dcdf">
                      {{ trans('messages.footer_privacy_cookies') }}
                  </a>
              </p>
          </div>
          <div class="col-md-2"></div>
        </div>
    </div>
</footer>
