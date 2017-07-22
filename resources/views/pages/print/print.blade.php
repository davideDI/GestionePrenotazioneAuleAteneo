@extends('layouts.layout')
    @section('content')
    
        <div class="row">
            <!-- Sezione filtri ricerca -->
            <div class="col-md-3"></div>
            
            <div class="col-md-6">
                <div class="row">
                        
                    <div class="col-md-12">

                        <legend>{{ trans('messages.pdf_title') }}</legend> 
                        
                        <form method="POST" action="{{URL::to('/download-pdf')}}">
                            {{ csrf_field() }}
                            <select id="group_id" name="group_id" class="listOfGroupsItems"
                                    style="width: 100%">
                                <option></option>
                                @if(!empty($groupsList))
                                    @foreach($groupsList as $group)
                                        <option value="{{$group->id}}">
                                            {{$group->name}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                            <hr>

                            <select id="resource_id" name="resource_id" class="listOfResourcesItems"
                                    style="width: 100%">
                                <option></option>
                                @if(!empty($resourceList))
                                    @foreach($resourceList as $resource)
                                        <option value="{{$resource->id}}">
                                            {{$resource->name}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                            <hr>

                            <label for="date_search">{{ trans('messages.common_from') }}</label>
                            <input type="text" class="form-control date_search" name="date_search_from" size="10">

                            <hr>

                            <label for="date_search">{{ trans('messages.common_to') }}</label>
                            <input type="text" class="form-control date_search" name="date_search_to" size="10">

                            <hr>
                        
                            <input type="submit" class="btn btn-primary" value="Test Print" />
                        </form>
                        
                    </div>
                        
                </div>
                
                
            </div>
            
            <div class="col-md-3"></div>
            
        </div>
    
    
        <script>
        
            $(document).ready(function() {
                $(".listOfGroupsItems").select2({
                    placeholder: "{{ trans('messages.booking_date_select_group') }}"
                });

                $(".listOfResourcesItems").select2({
                    placeholder: "{{ trans('messages.booking_date_select_resource') }}"
                });
            });
            
            $("#group_id").on("change", function() {
                getResources($("#group_id").val());
            });
            
            $( function() {
                $( ".date_search" ).datepicker({ dateFormat: 'dd-mm-yy' });
            } );
            
            function getResources(idGroup) {
                $("#resource_id").val(null);
                var selectedGroup = { 'idGroup' : idGroup};
                $('#resource_id').select2({
                    placeholder : "{{ trans('messages.booking_date_select_resource') }}",
                    ajax : {
                        type: 'post',
                        url: "{{URL::to('/resources')}}",
                        dataType: 'json',
                        data: selectedGroup,
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: false
                    }
                });
                                
            }
            
        </script>
    
    @endsection
