@extends('student.layout.main')
@section('title') Give Feedbacks @endsection

@section('content')
<div class="container">
    <div class="section">
        @section('button')
        @endsection
        
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <div class="row">
                        {!! Form::model($data, ['url' => [env('student').'/feedbacks'],'files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!}
                        <h4 class="header2">Give Feedbacks Here</h4>
                        @include('student.helpdesk.feedbacks.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection