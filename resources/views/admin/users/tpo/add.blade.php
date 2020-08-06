@extends('admin.layout.main')
@section('title') Add New Tpo / Company HR @endsection

@section('content')
<div class="container">
    <div class="section">
        @section('button')
        <a href="{{ Asset($link) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">List</a>
        @endsection
        
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <div class="row">
                        {!! Form::model($data, ['url' => [env('admin').'/tpo'],'files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!}
                        <h4 class="header2">Create New Tpo / Company HR Here</h4>
                        @include('admin.users.tpo.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection