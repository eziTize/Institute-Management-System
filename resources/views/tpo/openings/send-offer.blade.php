@extends('tpo.layout.main')


@section('title') Send offer to {{$student->name}} @endsection


@section('content')

<div class="container">

    <div class="section">

        <div class="row">


              <div class="col s12 m12 l12">

            {!! Form::model($data, ['method' => 'PATCH','url' => [env('tpo').'/openings/'.$data->id.'/send-offer-letter'],'files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!}


                <div class="col s12 m12 l12">

                    <div class="card-panel">

                        <div class="row">



                            <div class="input-field col s12 l6">

                                <i class="fa fa-info prefix"></i>

                                 {!! Form::text('name',$opening->o_type,['id' => 'o_type','required' => 'required','disabled' => 'disabled']) !!}

                                     <label for="o_type" style="color: black"> Offered Job For </label>

                            </div>


                            <div class="input-field col s12 l6">

                                <i class="fa fa-calendar prefix"></i>

                        {!! Form::date('join_date',null,['id' => 'join_date','required' => 'required','placeholder' => 'Choose joining date','class' => 'datepicker']) !!}

                                <label for="join_date" style="color: black" class="active">Joining Date *</label>

                            </div>


                    </div>


                <div class="col s12 m12 l12">


                        <div class="row">

                        @include('tpo.openings.upload_field')

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