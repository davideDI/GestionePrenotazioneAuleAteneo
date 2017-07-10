@extends('layouts.layout')
    @section('content')
    
        <div class="row">
            <!-- Sezione filtri ricerca -->
            <div class="col-md-3">
                
                <div class="row">
                        
                    <div class="col-md-12">

                        <legend>{{ trans('messages.search_title') }}</legend> 
                        
                        <label for="groupSelected">{{ trans('messages.search_group') }}</label>
                        <span id="no_group_selected" style="display: none" class="label label-danger">
                            <strong>{{ trans('messages.search_page_list_groups_empty') }}</strong>
                        </span>
                        <select id="listOfGroups"  name="groupSelected"
                                class="js-example-placeholder-multiple form-control"
                                multiple="multiple"
                                style="width: 100%">
                            <option></option>
                            @foreach($groupsList as $group)
                                <option value="{{$group->id}}">
                                    {{$group->name}}
                                </option>
                            @endforeach
                        </select>
                        
                        <br><br>
                        
                        <label for="capacity">{{ trans('messages.search_capacity') }}</label>
                        <input type="number" class="form-control" name="capacity" id="capacity" min="5" size="3">
                        
                        <br>
                        
                        <label for="date_search">{{ trans('messages.search_date') }}</label>
                        <span id="no_date_search" style="display: none" class="label label-danger">
                            <strong>{{ trans('messages.search_page_list_groups_empty') }}</strong>
                        </span>
                        <input type="text" class="form-control" name="date_search" id="date_search" size="10">
                        
                        <br>
                        
                        <label for="date_start">{{ trans('messages.index_calendar_event_start') }}</label>
                        <input type="time" class="form-control" name="date_start" id="date_start" onchange="szAdjustEndTime()" min="08:00" max="20:30" value="10:00">
                        
                        <br>
                        
                        <label for="duration">{{ trans('messages.search_duration') }}</label>
                        <select name="duration" class="form-control" id="duration" onchange="szAdjustEndTime()">
                            <option value="00:30">30 min</option>
                            <option value="01:00">1 ora</option>
                            <option value="01:30">1h 30min</option>
                            <option value="02:00" selected="selected">2 ore</option>
                            <option value="02:30">2h 30min</option>
                            <option value="03:00">3 ore</option>
                            <option value="03:30">3h 30min</option>
                            <option value="04:00">4 ore</option>
                            <option value="04:30">4h 30min</option>
                            <option value="05:00">5 ore</option>
                            <option value="05:30">5h 30min</option>
                            <option value="06:00">6 ore</option>
                            <option value="06:30">6h 30min</option>
                            <option value="07:00">7 ore</option>
                            <option value="07:30">7h 30min</option>
                            <option value="08:00">8 ore</option>
                            <option value="08:30">8h 30min</option>
                            <option value="09:00">9 ore</option>
                            <option value="09:30">9h 30min</option>
                            <option value="10:00">10 ore</option>
                            <option value="10:30">10h 30min</option>
                            <option value="11:00">11 ore</option>
                            <option value="11:30">11h 30min</option>
                        </select>
                        
                        <br>
                        
                        <label for="date_end">{{ trans('messages.index_calendar_event_end') }}</label>
                        <input type="text" class="form-control" name="date_end" id="date_end" readonly="readonly" size="5" value="12:00">
                        
                        <br>
                        
                        <input type="button" class="btn btn-primary" value="{{ trans('messages.search_search_capacity') }}" onclick="searchByCapacity()">
                        <br><br>
                        <input type="button" class="btn btn-primary" value="{{ trans('messages.search_search_free') }}" onclick="searchByFree()">
                        
                    </div>
                </div>
                
            </div>
            
            <!-- Sezione risultati -->
            <div class="col-md-9">
                
                <div class="row">
                        
                    <div class="col-md-12" id="searchResult">
                        
                        <img src="{{URL::asset('lib/images/lente_ingrandimento.png')}}" width="150" height="95" style="margin-left: 45%; margin-top: 30%;" alt="lente">
                        
                    </div>
                    
                </div>
                
            </div>
        </div>
    
        <script type="text/javascript">
            
            function searchByCapacity() {
                
                if($("#listOfGroups").val().length == 0) {
                    
                    $("#no_group_selected").show();
                    
                } else {
               
                    var dataInput = {

                        'listOfGroups' : $("#listOfGroups").val(),
                        'capacity'     : $("#capacity").val(),
                        'date_search'  : $("#date_search").val(),
                        'date_start'   : $("#date_start").val(),
                        'date_end'     : $("#date_end").val()

                    };

                    $.ajax({

                        url: "{{URL::to('/search-by-capacity')}}",
                        type: 'POST',
                        dataType: 'json',
                        data: dataInput,
                        success: function(resourcesList) {

                            var result = "";
                            if(resourcesList.length > 0) {

                                var result = "<table class='table table-hover'>";
                                        result += "<thead>";
                                            result += "<th>{{trans('messages.common_structure')}}</th>";
                                            result += "<th>{{trans('messages.common_room_name')}}</th>";
                                            result += "<th>{{trans('messages.common_description')}}</th>";
                                            result += "<th>{{trans('messages.common_email_adimn')}}</th>";
                                            result += "<th>{{trans('messages.booking_capacity')}}</th>";
                                            @if(Session::has('session_id'))
                                                result += "<th></th>";
                                            @endif
                                        result += "</thead>";
                                        result += "<tbody>";

                                        for(var j=0; j < resourcesList.length; j++) {

                                            result += "<tr id='"+resourcesList[j].id+"'>";
                                                result += "<td>";
                                                    result += resourcesList[j].name;
                                                result += "</td>";
                                                result += "<td>";
                                                    result += resourcesList[j].group.name;
                                                result += "</td>";
                                                result += "<td>";
                                                    result += resourcesList[j].description;
                                                result += "</td>";
                                                result += "<td>";
                                                    result += resourcesList[j].room_admin_email;
                                                result += "</td>";
                                                result += "<td>";
                                                    result += resourcesList[j].capacity;
                                                result += "</td>";
                                                @if(Session::has('session_id'))
                                                    result += "<td>";
                                                        //TODO aggiustare link con utility di laravel
                                                        result += 
                                                        "<a href='../public/new-booking/"+resourcesList[j].id+"'>{{trans('messages.common_reservation')}}\n\
                                                         </a>";
                                                    result += "</td>";
                                                @endif
                                            result += "</tr>";

                                        }

                                        result += "</tbody>";
                                    result += "</table>";
                            } else {
                                result += "<h4 style='margin-left: 35%; margin-top: 30%;'>{{ trans('messages.search_no_result') }}</h4>";
                            }
                            $("#searchResult").html(result);
                        },
                        error: function(e) {
                             console.log(e.responseText);
                        },

                    });
                }    
                
            }
            
            function searchByFree() {
                
                var validatedInput = true;
                
                if($("#listOfGroups").val().length == 0) {
                    
                    $("#no_group_selected").show();
                    validatedInput = false;
                    
                }
                
                if($("#date_search").val().length == 0) {
                    
                    $("#no_date_search").show();
                    validatedInput = false;
                    
                } 
                
                if(validatedInput == true) {
                    
                    var dataInput = {

                        'listOfGroups' : $("#listOfGroups").val(),
                        'capacity'     : $("#capacity").val(),
                        'date_search'  : $("#date_search").val(),
                        'date_start'   : $("#date_start").val(),
                        'date_end'     : $("#date_end").val(),

                    };

                    $.ajax({

                        url: "{{URL::to('/search-by-free')}}",
                        type: 'POST',
                        dataType: 'json',
                        data: dataInput,
                        success: function(resourcesList) {
                            console.log(resourcesList);
                            var result = "";
                            if(resourcesList.length > 0) {

                                var result = "<table class='table table-hover'>";
                                        result += "<thead>";
                                            result += "<th>{{trans('messages.common_structure')}}</th>";
                                            result += "<th>{{trans('messages.common_room_name')}}</th>";
                                            result += "<th>{{trans('messages.common_description')}}</th>";
                                            result += "<th>{{trans('messages.common_email_adimn')}}</th>";
                                            result += "<th>{{trans('messages.booking_capacity')}}</th>";
                                            @if(Session::has('session_id'))
                                                result += "<th></th>";
                                            @endif
                                        result += "</thead>";
                                        result += "<tbody>";

                                        for(var j=0; j < resourcesList.length; j++) {

                                            result += "<tr id='"+resourcesList[j].id_resources+"'>";
                                                result += "<td>";
                                                    result += resourcesList[j].name;
                                                result += "</td>";
                                                result += "<td>";
                                                    result += resourcesList[j].name_resource;
                                                result += "</td>";
                                                result += "<td>";
                                                    result += resourcesList[j].description_resource;
                                                result += "</td>";
                                                result += "<td>";
                                                    result += resourcesList[j].room_admin_email;
                                                result += "</td>";
                                                result += "<td>";
                                                    result += resourcesList[j].capacity;
                                                result += "</td>";
                                                @if(Session::has('session_id'))
                                                    result += "<td>";
                                                        //TODO aggiustare link con utility di laravel
                                                        result += 
                                                        "<a href='../public/new-booking/"+resourcesList[j].id_resources+"/"+$("#date_search").val()+" "+$("#date_start").val()+"/"+$("#date_search").val()+" "+$("#date_end").val()+"'>{{trans('messages.common_reservation')}}\n\
                                                         </a>";
                                                    result += "</td>";
                                                @endif
                                            result += "</tr>";

                                        }

                                        result += "</tbody>";
                                    result += "</table>";
                            } else {
                                result += "<p>{{ trans('') }}</p>";
                            }
                            $("#searchResult").html(result);
                        },
                        error: function(e) {
                            console.log(e.responseText);
                        },

                    });
                    
                }
            }
            
            $(document).ready(function() {
              $(".js-example-placeholder-multiple").select2({
                  placeholder: "{{ trans('messages.booking_date_select_group') }}"
              })
            });
        
            $( function() {
                $( "#date_search" ).datepicker({ dateFormat: 'dd-mm-yy' });
            } );
            
            String.prototype.szZeroPad = function (i) {
                var str = this;
                var o = "";
                o = o+str;
                if (str.length<parseInt(i)) {
                        for (var x=0; x<(parseInt(i) - str.length); x++) {
                                o = "0"+o;
                        }
                }
                return o;
            }
            
            function szAdjustEndTime() {
            
                var i = document.getElementById('date_start').value;
                var d = document.getElementById('duration').value;
                if(i !== '') {
                    var da = d.split(':');
                    var dh = parseInt(da[0]);
                    var dm = parseInt(da[1]);
                    var ia = i.split(':');
                    var ih = parseInt(ia[0]);
                    var im = parseInt(ia[1]);
                    var sz_h = ih+dh;
                    var sz_m = im+dm;
                    var sz_mh = Math.floor(sz_m / 60);
                    sz_h = (sz_h + sz_mh).toString();
                    sz_m = (sz_m - (sz_mh * 60)).toString();
                    document.getElementById('date_end').value = sz_h.szZeroPad(2) + ":" + sz_m.szZeroPad(2);
                }

            }
            
        </script>
        
    @endsection
