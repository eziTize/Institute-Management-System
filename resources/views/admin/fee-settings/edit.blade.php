@extends('admin.layout.main')

@section('title') Edit {{$data->fee_type}} @endsection



@section('content')

<div class="container">

    <div class="section">

        @section('button')

        <a href="{{ Asset($link) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">Cancel</a>

        @endsection



        <div class="row">

            <div class="col s12 m12 l12">

                <div class="card-panel">

                    <div class="row">

                        {!! Form::model($data, ['method' => 'PUT','url' => env('admin').'/fee-settings/'.$data->slug,'files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!}

                        <h4 class="header2">Edit Details Here</h4>

                        @include('admin.fee-settings.form',['id' => $id])

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection