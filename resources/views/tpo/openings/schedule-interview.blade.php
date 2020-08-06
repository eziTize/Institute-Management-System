@extends('tpo.layout.main')

@if($data->interview_date)

@section('title') Re-schedule Interview For {{$student->name }} @endsection

@else

@section('title') Schedule Interview For {{$student->name }} @endsection

@endif

@section('content')

<div class="container">

    <div class="section">

        <div class="row">


              <div class="col s12 m12 l12">

            {!! Form::model($data, ['method' => 'PATCH','url' => [env('tpo').'/openings/'.$data->id.'/schedule-interview-date'],'files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!}


                <div class="col s12 m12 l12">

                    <div class="card-panel">

                        <div class="row">



                            <div class="input-field col s12 l6">

                                <i class="fa fa-info prefix"></i>

                                 {!! Form::text('name',$opening->o_type,['id' => 'o_type','required' => 'required','disabled' => 'disabled']) !!}

                                     <label for="o_type" style="color: black"> Interview For </label>

                            </div>


                            <div class="input-field col s12 l6">

                                <i class="fa fa-calendar prefix"></i>

                        {!! Form::date('interview_date',null,['id' => 'interview_date','required' => 'required','placeholder' => 'Pick interview date','class' => 'datepicker']) !!}

                                <label for="interview_date" style="color: black" class="active">Interview Date</label>

                            </div>


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