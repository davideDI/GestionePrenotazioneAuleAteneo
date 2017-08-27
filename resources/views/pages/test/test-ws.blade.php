@extends('layouts.layout')
    @section('content')
    
<select id="resourceSelect" 
        class="listaFacolta" 
        style="width: 90%">
    @foreach($result as $resource)
        <option>
            {{ $resource }}
        </option>
    @endforeach
</select>

<!--
@foreach($result as $res)
    {{ $res }}
    <br/>
@endforeach-->



 <script type="text/javascript">
    $(document).ready(function() {
      $(".listaFacolta").select2();
    });
</script>
@endsection
