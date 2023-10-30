@extends('layout.baseLayout')

@section('content')
   <div class="create-form-link">
       <p>Lets create a Form !</p>
       <button onclick="window.location='{{ url("create") }}'">Create</button>
   </div>
@endsection