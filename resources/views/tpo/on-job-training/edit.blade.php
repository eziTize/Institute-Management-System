@extends('tpo.layout.main')

@section('title') Edit On Job Training @endsection



@section('content')

<div class="container">

    <div class="section">

        @section('button')

        <a href="{{ Asset($link) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">List</a>

        @endsection

        

        <div class="row">

            <div class="col s12 m12 l12">

                {!! Form::model($data, ['method' => 'PUT','url' => env('tpo').'/on-job-training/'.$data->id.'/update','files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!}

                <h4 class="header2">Edit On Job Training Details</h4>

                @include('tpo.on-job-training.form',['id' => $id])

            </div>

        </div>

    </div>

</div>

@endsection