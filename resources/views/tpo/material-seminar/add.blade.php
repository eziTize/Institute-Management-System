@extends('tpo.layout.main')

@section('title') Add New Material Seminar @endsection



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

                        {!! Form::model($data, ['url' => [env('tpo').'/material-seminar/store'],'files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!}

                        <h4 class="header2">Material Seminar Details</h4>

                        @include('tpo.material-seminar.form')

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection