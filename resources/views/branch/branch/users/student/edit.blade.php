@extends('branch.layout.main')
@section('title') Edit Student @endsection

@section('content')
<div class="container">
    <div class="section">
        @section('button')
        <a href="{{ Asset($link) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">List</a>
        @endsection
        
        <div class="row">
            <div class="col s12 m12 l12">
                {!! Form::model($data, ['method' => 'PUT','url' => env('branch').'/student/'.$data->id,'files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!}
                @include('branch.users.student.form',['id' => $id])
            </div>
        </div>
    </div>
</div>
@endsection