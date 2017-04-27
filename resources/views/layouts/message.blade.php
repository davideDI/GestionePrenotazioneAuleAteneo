<div class="row">

    @if($errors->any())
    
        <div class="col-md-2"></div>

        <div class="col-md-8">
                
            @if($errors->first() == -1)
                <div class="alert alert-danger" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ trans('messages.'.$errors->first()) }}
                </div>
            <!-- Messaggi di Successo -->
            @elseif($errors->first() >= 100 && $errors->first() < 300)
                <div class="alert alert-success" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ trans('messages.'.$errors->first()) }}
                </div>

            <!-- Messaggi di Warning -->
            @elseif($errors->first() >= 300 && $errors->first() < 500)
                <div class="alert alert-warning" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ trans('messages.'.$errors->first()) }}
                </div>

            <!-- Messaggi di Errore -->
            @elseif($errors->first() >= 500 && $errors->first() < 700)
                <div class="alert alert-danger" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ trans('messages.'.$errors->first()) }}
                </div>
            @else($errors->first() >= 1000)
                <div class="alert alert-danger" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ trans('messages.'.$errors->first()) }}
                </div>
            @endif
            
        </div>
        
        <div class="col-md-2"></div>
        
    @endif
    
    @if(Session::has('success'))
    
        <div class="col-md-2"></div>

        <div class="col-md-8">
                
            <!-- Messaggi di Successo -->
            @if(session('success') >= 100 && session('success') < 300)
                <div class="alert alert-success" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ trans('messages.'.session('success')) }}
                    {{Session::forget('success')}}
                </div>
            @endif
            
        </div>
        
        <div class="col-md-2"></div>
        
    @endif
    
    <!-- Messaggi utilizzati per la conferma / respinta prenotazione -->
        <div class="col-md-2"></div>

        <div class="col-md-8">
            
            <div id="message-success" class="alert alert-success" role="alert" style="display: none;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{trans('messages.common_success')}}
            </div>

            <div id="message-danger" class="alert alert-danger" role="alert" style="display: none;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{trans('messages.common_danger')}}
            </div>
            
        </div>
        
        <div class="col-md-2"></div>
        
</div>
