@extends('branch.layout.main')
@section('title') View Teacher @endsection

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
                        <?php /*{!! Form::model($data, ['method' => 'PUT','url' => env('branch').'/teacher/'.$data->id,'files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!} /* As of now Teacher is not managed on branch */ ?>
                        {!! Form::model($data, ['files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!}
                        <h4 class="header2">View Teacher Detail Here</h4>
                        @include('branch.users.teacher.form',['id' => $id])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection