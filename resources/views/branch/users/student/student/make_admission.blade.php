@extends('branch.layout.main')

@section('title') Admission for Course @endsection



@section('content')

<div class="container">

    <div class="section">
        

        <div class="row">

            <div class="col s12 m12 l12">

                {!! Form::model($data, ['url' => [env('branch').'/student/makeAdmission/'.$data->id],'files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!}

                

                <h4 class="header2">Admission</h4>



                <div class="col s12 m12 l12">

                    <div class="card-panel">


                        <div class="row">

                            <div class="input-field col s12 l6">

                                <i class="fa fa-calendar prefix"></i>

                                    {!! Form::date('admission_date',null,['id' => 'admission_date','class' => 'datepicker','required' => 'required']) !!}

                                     <label for="admission_date">Admission Date *</label>
                            </div>


                                <div class="input-field col s12 l6">

                                    <i class="fa fa-money prefix"></i>

                                    {!! Form::number('admission_fee', $extra_fees->find(2)->fee_amount ,['id' => 'admission_fee','required' => 'required']) !!}

                                    <label for="admission_fee">Admission Fee (Rs) *</label>

                                </div>

                        </div>

                        <div class="row">

                                

                                <div class="input-field col s12 l6">

                                    <i class="fa fa-money prefix"></i>

                                    {!! Form::number('reg_fee',null,['id' => 'reg_fee','required' => 'required']) !!}

                                    <label for="reg_fee">Registration Fee (Rs) *</label>

                                </div>


                                <div class="input-field col s12 l6">

                                    <i class="fa fa-money prefix"></i>

                                    {!! Form::number('sq_deposit',0.00,['id' => 'sq_deposit', 'required' => 'required']) !!}

                                    <label for="sq_deposit"> Secuirity Deposit (Rs) *</label>

                                </div>

                                <div class="input-field col s12 l6">

                                    <i class="fa fa-money prefix"></i>

                                    {!! Form::number('ppts_fee',$extra_fees->find(1)->fee_amount,['id' => 'ppts_fee', 'required' => 'required']) !!}

                                    <label for="ppts_fee">Prospectus Fee (Rs) *</label>

                                </div>



                                <div class="input-field col s12 l6">

                                    <i class="fa fa-money prefix"></i>

                                    {!! Form::number('discount',0.00,['id' => 'discount']) !!}

                                    <label for="discount">Discount/Scholarship (Rs)</label>

                        </div>

                    </div>

                </div>



                <h4 class="header2">Course Details</h4>



                <div class="col s12 m12 l12">

                    <div class="card-panel">

                        <div class="row">

                            <div class="input-field col s12 l4">

                                <select class="browser-default" name="branch_course" required onchange="getBatch(this.value)">

                                    <option value="">Select Course</option>

                                    @foreach($branch_course as $brn_crs)

                                    <option value="{{ $brn_crs->id }}">

                                        {{ $course->find($brn_crs->course_id)->name }} - Fee: {{ $brn_crs->fee }}

                                    </option>

                                    @endforeach

                                </select>

                            </div>



                            <div class="input-field col s12 l4">

                                <select class="browser-default" name="batch" required>

                                    <option value="">Select Batch</option>

                                </select>

                            </div>



                            <div class="input-field col s12 l4">

                                {!! Form::date('course_join',null,['id' => 'course_join','required' => 'required','placeholder' => 'Date Added','class' => 'datepicker']) !!}

                                <label for="course_join" class="active">Course Joining</label>

                            </div>

                        </div>

                    </div>

                </div>



                <h4 class="header2"> Installment Type </h4>



                 <div class="col s12 m12 l12">

                  <div class="card-panel">



                        {!! Form::select('installment',['One Time' => 'One Time', 'Monthly' => 'Monthly', 'Weekly' => 'Weekly' ],$data->installment) !!}



        

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



@section('js')

<script>

    function getBatch(course_id){

        if(course_id){

            $.get("{{ Asset(env('branch').'/course/getBatch') }}/"+course_id, function(data){

                var html = "<option value=\"\">Select Batch</option>";

                data.forEach(function(bat){

                    html += "<option value=\""+bat.id+"\">"+bat.name+"</option>";

                });

                $('[name="batch"]').html(html);

                $('[name="batch"]').val("{{ Old('batch') ?? '' }}");

            });

        }else{

            var html = "<option value=\"\">Select Batch</option>";

            $('[name="batch"]').html(html);

            $('[name="batch"]').val("");

        }

    }



    @if(Old('branch_course'))

    $('[name="branch_course"]').val("{{ Old('branch_course') ?? '' }}");

    getBatch("{{ Old('branch_course') }}");

    @endif

</script>

@endsection