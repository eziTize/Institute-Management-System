@extends('branch.layout.main')
@section('title') Add New Student @endsection

@section('content')
<div class="container">
    <div class="section">
        @section('button')
        <a href="{{ Asset($link) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">List</a>
        @endsection
        
        <div class="row">
            <div class="col s12 m12 l12">
                {!! Form::model($data, ['url' => [env('branch').'/student'],'files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!}
                @include('branch.users.student.form')
            </div>
        </div>
    </div>
</div>
@endsection