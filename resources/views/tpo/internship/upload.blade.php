@extends('tpo.layout.main')

@section('title') Add Images for Internship @endsection



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


                        {!! Form::model($data, ['method' => 'PUT','url' => env('tpo').'/internship/'.$data->id.'/store-image','files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!}

                        <h4 class="header2">Upload Internship Images</h4>

                        @include('tpo.internship.upload_form')

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection