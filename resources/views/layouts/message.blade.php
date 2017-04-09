<div class="row">

    @if(! empty($messageCode))
    
        <div class="col-md-2"></div>

        <div class="col-md-8">

            <!-- Messaggi di Successo -->
            @if($messageCode >= 100 && $messageCode < 300)
                <div class="alert alert-success" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ trans('messages.'.$messageCode) }}
                </div>

            <!-- Messaggi di Warning -->
            @elseif($messageCode >= 300 && $messageCode < 500)
                <div class="alert alert-warning" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ trans('messages.'.$messageCode) }}
                </div>
        
            <!-- Messaggi di Errore -->
            @else($messageCode >= 500 && $messageCode < 700)
                <div class="alert alert-danger" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ trans('messages.'.$messageCode) }}
                </div>
            @endif

        </div>
        
        <div class="col-md-2"></div>

    @endif

</div>
