@extends('layouts.layout')
    @section('content')
    
    @foreach($testDate as $t)
        {{$t}} <br>
    @endforeach
    
    
    
    @endsection
