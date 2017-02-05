@extends('layouts.layout')
@section('content')
<div>
    
    @foreach ($tipiEvento as $tipoEvento)
        <p>{{ $tipoEvento->name }}</p>
    @endforeach
    
</div>
@endsection
