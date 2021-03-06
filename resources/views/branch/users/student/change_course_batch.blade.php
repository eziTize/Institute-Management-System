@extends('branch.layout.main')

@section('title') Change Batch @endsection



@section('content')

<div class="container">

    <div class="section">

        @section('button')

        <a href="{{ Asset($link) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">Back</a>

        @endsection

        

        <div class="row">

            <div class="col s12 m12 l12">

                {!! Form::model($data, ['url' => [env('branch').'/student/change-batch/'.$data->id],'files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!}



                <h4 class="header2">Change Batch</h4>



                <div class="col s12 m12 l12">

                    <div class="card-panel">

                        <div class="row">


                            <div class="input-field col s12 l6">

                                <i class="fa fa-info prefix"></i>

                                 {!! Form::text('name',$data->course_name,['id' => 'course_name','required' => 'required','disabled' => 'disabled']) !!}

                                     <label for="course_name" style="color: black">Course Name </label>

                            </div>



                            <div class="input-field col s12 l6">

                                <i class="fa fa-calendar prefix"></i>

                                {!! Form::date('course_join',null,['id' => 'course_join','required' => 'required','placeholder' => 'Date Added','class' => 'datepicker', 'disabled' => 'disabled']) !!}

                                <label for="course_join" style="color: black" class="active">Course Joining</label>

                            </div>




                        </div>


                        <div class="row">

                        <div class="input-field col s12">


                                <select class="browser-default" name="batch_id" required>


                                       <option value="{{$data->batch_id}}"> Batch: {{ $batch->find($data->batch_id)->name }}, Fee: {{  $branch_course->find($batch->find($data->batch_id)->branch_course_id)->fee  }}, Duration: {{ $course->find($branch_course->find($batch->find($data->batch_id)->branch_course_id)->course_id)->duration }} Months </option>

                                          @foreach($batch as $bch)

                                         @if($data->branch_course_id == $bch->branch_course_id && $bch->id != $data->batch_id)

                                              <option value="{{ $bch->id }}">

                                     Batch: {{ $bch->name }}, Fee: {{ $branch_course->find($bch->branch_course_id)->fee }}, Duration: {{ $course->find($branch_course->find($bch->branch_course_id)->course_id)->duration }} Months
                
                                     </option>

                                        @endif


                                         @endforeach


                                </select>


                                <label for="course_join" style="color: black" class="active">Select Batch</label>



                            </div>

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