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
                @if(Session::has('ruolo') && Session::get('ruolo') == \App\TipUser::ROLE_ADMIN_ATENEO)
                    <td>
                        <a href="{{URL::to('/group', $selectedGroup->id )}}"
                            <span class='glyphicon glyphicon-pencil univaq_color_span' aria-hidden='true'></span>
                        </a>
                    </td>
                @endif

            </div>
        </div>

        <div class="row"><div class="col-md-12"></div></div>

        <div class="row">
            <div class="col-md-12">
                @if(Session::has('ruolo') && Session::get('ruolo') == \App\TipUser::ROLE_ADMIN_ATENEO)
                    <a class="btn btn-primary univaq_button" href="{{URL::to('/insert-group')}}">
                        {{ trans('messages.manage_resource_inset_group') }}
                    </a>

                    <a class="btn btn-primary univaq_button" href="{{URL::to('/insert-resource')}}">
                        {{ trans('messages.manage_resource_inset_resource') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @if(count($resourceList) > 0)
                <div class="table-responsive" id="content" style="margin-top: 10px">
                    <table class='table table-hover' style="font-size: 12px">
                        <thead>
                            @if(Session::has('ruolo') && Session::get('ruolo') == \App\TipUser::ROLE_ADMIN_ATENEO)
                            <th></th>
                            @endif
                            <th>{{trans('messages.booking_date_resource')}}</th>
                            <th>{{trans('messages.booking_capacity')}}</th>
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
                                    @if(Session::has('ruolo') && Session::get('ruolo') == \App\TipUser::ROLE_ADMIN_ATENEO)
                                    <td>
                                        <a href="{{URL::to('/resource', $resource->id)}}"
                                            <span class='glyphicon glyphicon-pencil univaq_color_span' aria-hidden='true'></span>
                                        </a>
                                    </td>
                                    @endif

                                    <td>{{$resource->name}}</td>
                                    <td>{{$resource->capacity}}</td>
                                    <td>
                                        @if($resource->projector)
                                           <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                        @else
                                            <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($resource->screen_motor)
                                           <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                        @else
                                            <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($resource->screen_manual)
                                           <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                        @else
                                            <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($resource->pc)
                                           <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                        @else
                                            <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($resource->wire_mic)
                                           <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                        @else
                                            <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($resource->wireless_mic)
                                           <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                        @else
                                            <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($resource->overhead_projector)
                                           <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                        @else
                                            <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($resource->visual_presenter)
                                           <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                        @else
                                            <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($resource->wiring)
                                           <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                        @else
                                            <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($resource->blackboard)
                                           <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                        @else
                                            <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($resource->equipment)
                                           <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                        @else
                                            <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($resource->audio)
                                           <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                        @else
                                            <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                        @endif
                                    </td>

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
