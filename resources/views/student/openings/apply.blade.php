@extends('student.layout.main')


@section('title') Send Application @endsection


@section('content')

<div class="container">

    <div class="section">

        @section('button')

        <a href="{{ Asset($link) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">Back</a>

        @endsection

        <div class="row">


              <div class="col s12 m12 l12">

            {!! Form::model($data, ['method' => 'POST','url' => [env('student').'/openings/'.$data->id.'/apply'],'files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!}


                <div class="col s12 m12 l12">

                    <div class="card-panel">

                        <div class="row">



                            <div class="input-field col s12 l6">

                                <i class="fa fa-user prefix"></i>

                                 {!! Form::text('name',$student->name,['id' => 'student_name','required' => 'required','disabled' => 'disabled']) !!}

                                     <label for="o_type" style="color: black"> Student Name </label>

                            </div>


                            <div class="input-field col s12 l6">

                                <i class="fa fa-info prefix"></i>

                         {!! Form::text('name',$data->o_type,['id' => 'op_name','required' => 'required','disabled' => 'disabled']) !!}

                                     <label for="o_type" style="color: black"> Application For </label>

                            </div>


                    </div>


                <div class="col s12 m12 l12">


                        <div class="row">

                        @include('student.openings.upload_field')

                        <span id="upload_field"></span>

                        </div>
                </div>



                 <div class="row">

                    <div class="input-field col s12">

                        <div class="input-field col s12">

                            <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Submit <i class="mdi-content-send right"></i></button>

                        </div>

                    </div>

                </div>


            </div>


        </div>


    </div>

</div>

@endsection