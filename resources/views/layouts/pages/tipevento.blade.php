@extends('layouts.layout')
@section('content')
<div>
    
    @foreach ($tipiEvento as $tipoEvento)
        <p>{{ $tipoEvento->nome }}</p>
    @endforeach
    
</div>
@endsection
