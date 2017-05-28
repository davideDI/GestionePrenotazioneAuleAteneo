@extends('layouts.layout')
    @section('content')
    
        <div class="row">
            <div class="col-md-12">
                
                <h4>{{trans('messages.manage_resource_title')}}</h4> 
                <select id="groupSelect" 
                        onChange="window.location.href=this.value" 
                        class="listOfGroups" 
                        style="width: 20%">
                    @foreach($groupList as $group)
                        <option></option>
                        <option value="{{URL::to('/manage-resources', $group->id)}}">
                            {{$group->name}}
                        </option>
                    @endforeach
                </select>
                
                <a class="btn btn-primary" href="{{URL::to('/insert-group')}}">
                    {{ trans('messages.manage_resource_inset_group') }}
                </a>
                
                <a class="btn btn-primary" href="{{URL::to('/insert-resource')}}">
                    {{ trans('messages.manage_resource_inset_resource') }}
                </a>
                
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                @if(count($resourceList) > 0)
                <div class="table-responsive" id="content" style="margin-top: 10px">
                    <table class='table table-hover' style="font-size: 12px">
                        <thead>
                            <th>{{trans('messages.booking_date_resource')}}</th>
                            <th>{{trans('messages.booking_capacity')}}</th>
                            <th>{{trans('messages.booking_room_admin_email')}}</th>
                            <th>{{trans('messages.booking_projector')}}</th>
                            <th>{{trans('messages.booking_screen_motor')}}</th>
                            <th>{{trans('messages.booking_screen_manual')}}</th>
                            <th>{{trans('messages.booking_pc')}}</th>
                            <th>{{trans('messages.booking_wire_mic')}}</th>
                            <th>{{trans('messages.booking_wireless_mic')}}</th>
                            <th>{{trans('messages.booking_overhead_projector')}}</th>
                            <th>{{trans('messages.booking_visual_presenter')}}</th>
                            <th>{{trans('messages.booking_wiring')}}</th>
                            <th>{{trans('messages.booking_blackboard')}}</th>
                            <th>{{trans('messages.booking_equipment')}}</th>
                            <th>{{trans('messages.booking_audio')}}</th>
                            <th>{{trans('messages.booking_network')}}</th>
                            <th>{{trans('messages.booking_note')}}</th>
                        </thead>
                        <tbody>
                            @foreach($resourceList as $resource)
                                <tr>    
                                    <td>{{$resource->name}}</td>
                                    <td>{{$resource->capacity}}</td>
                                    <td>{{$resource->room_admin_email}}</td>
                                    <td>{{$resource->projector}}</td>
                                    <td>{{$resource->screen_motor}}</td>
                                    <td>{{$resource->screen_manual}}</td>
                                    <td>{{$resource->pc}}</td>
                                    <td>{{$resource->wire_mic}}</td>
                                    <td>{{$resource->wireless_mic}}</td>
                                    <td>{{$resource->overhead_projector}}</td>
                                    <td>{{$resource->visual_presenter}}</td>
                                    <td>{{$resource->wiring}}</td>
                                    <td>{{$resource->blackboard}}</td>
                                    <td>{{$resource->equipment}}</td>
                                    <td>{{$resource->audio}}</td>
                                    <td>{{$resource->network}}</td>
                                    <td>{{$resource->note}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p style="text-align: center"><strong>{{trans('messages.manage_resource_no_resources')}}</strong></p>
                @endif
            </div>
        </div>
    
        <script type="text/javascript">
            $(document).ready(function() {              
                $(".listOfGroups").select2({
                    placeholder: "{{ $selectedGroup->name }}"
                });
            });
        </script>
    
    @endsection
