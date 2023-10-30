@extends('layout.baseLayout')

@section('content')
   <div class="create-form">
       <h2>From List</h2>

        @if(session()->has('msg'))
            <div class="alert alert-success" role="alert">
               {{ session()->get('msg') }}
            </div>
        @endif

       <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($list as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->form_name }}</td>
                    <td class=""><a href="{{ url('edit/'.$data->id.'') }}" class="btn btn-info">Edit</a><a href="{{ url('form-template/'.$data->id.'') }}" class="btn btn-warning ml-2">Preview</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
   </div>
@endsection