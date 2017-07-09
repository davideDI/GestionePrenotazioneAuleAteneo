<div class="row">

    @if(!empty($errors) && $errors->any())
    
        <div class="col-md-2"></div>

        <div class="col-md-8">
                
            <!-- Messaggi di Errore  -->
            <div class="alert alert-danger" role="alert">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ trans('messages.'.$errors->first()) }}
            </div>
            
        </div>
        
        <div class="col-md-2"></div>
        
    @endif
    
    @if(Session::has('success'))
    
        <div class="col-md-2"></div>

        <div class="col-md-8">
                
            <!-- Messaggi di Successo -->
            <div class="alert alert-success" role="alert">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ trans('messages.'.session('success')) }}
                {{Session::forget('success')}}
            </div>
            
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
