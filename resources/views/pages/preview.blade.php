@extends('layout.baseLayout')

@push('create-form')
<style>
.create-form {
    overflow: auto;
}

.create-form > *:not(:first-child) {
   margin-top: 20px;
}

.ingradiants, .trial-form {
    border: 1px solid gray;
    border-radius: 5px;
    width: 100%;
    padding: 10px 20px;
}

.ingradiants {
    display: flex;
    flex-wrap: wrap;
    justify-content: start;
    gap: 20px;
}

.ingradiants > * {
    cursor: pointer;
}

.preview .remove-ele {
    display: none;
}

</style>
@endpush

@section('content')
   <div class="preview">
       <h2>Fill and submit the Form:</h2>

        @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <p class="error-msg">{{$errors->first()}}</p>
        </div>
        @endif

        @if(session()->has('msg'))
            <div class="alert alert-success" role="alert">
               {{ session()->get('msg') }}
            </div>
        @endif
       
       <form action="{{ url('form-submit') }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $template->id }}" />

       {!! json_decode($template->form_body) !!}

       <button type="submit" class="btn btn-danger">Submit</button>
       </form>
    </div>
@endsection



