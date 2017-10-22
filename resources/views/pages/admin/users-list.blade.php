@extends('layouts.layout')
    @section('content')
    
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ url('/manage-user') }}">{{ trans('messages.acl_title_insert')}}</a>
                    </div>
                </div>
                
                <br>
                
                <div class="row">
                    <div class="col-md-12">
                        @if(count($listOfAcl) == 0)
                            <p>{{ trans('messages.acl_no_autorized_users') }}</p>
                        @else
                            <table class="table">
                                <thead>
                                    <th></th>
                                    <th>{{ trans('messages.acl_cn') }}</th>
                                    <th>{{ trans('messages.acl_email') }}</th>
                                    <th>{{ trans('messages.acl_tip_user') }}</th>
                                    <th>{{ trans('messages.manage_resource_tip_group_title') }}</th>
                                    <th>{{ trans('messages.acl_enable_access') }}</th>
                                    <th>{{ trans('messages.acl_enable_crud') }}</th>
                                </thead>
                                <tbody>
                                    @foreach ($listOfAcl as $acl)
                                        <tr>
                                            <td>
                                                <a href="{{URL::to('/acl', $acl->id)}}"
                                                    <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
                                                </a>
                                            </td>
                                            <td>
                                                {{ $acl->user->cn }}
                                            </td>
                                            <td>
                                                {{ $acl->user->email }}
                                            </td>
                                            <td>
                                                {{ $acl->user->tipUser->name }}
                                            </td>
                                            <td>
                                                @if(isset($acl->group_id))
                                                    {{ $acl->group->name }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($acl->enable_access)
                                                    <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                                 @else
                                                     <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                                 @endif
                                            </td>
                                            <td>
                                                @if($acl->enable_crud)
                                                    <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                                 @else
                                                     <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                                 @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    
    @endsection
