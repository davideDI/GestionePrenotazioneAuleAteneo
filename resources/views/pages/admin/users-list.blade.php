@extends('layouts.layout')
    @section('content')
    
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ url('/manage-user') }}">{{ trans('messages.acl_title_insert')}}</a>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="container">
                            @foreach ($listOfAcl as $acl)
                                {{ $acl->cn }}
                            @endforeach
                        </div>
                        {{ $listOfAcl->links() }}
                    </div>
                </div>
                
            </div>
        </div>
    
    @endsection
