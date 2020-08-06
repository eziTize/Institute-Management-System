@extends('branch.layout.main')

@section('title') Manage Course for {{ $student->find($id)->name }} @endsection



@section('content')

<div class="container">

    <div class="section">

        @section('button')

        <a href="{{ Asset($link ) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">Back</a>

        <a href="{{ Asset($link.'makeAdmission/'.$id) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px;margin-right:5px;"> Add Course </a>

        @endsection





        <div id="striped-table">

            <div class="row">

                <div class="col s12 m12 l12">

                    <table class="striped" >

                        <thead>

                            <tr>

                                <th >Course</th>

                                <th style=" text-align: center;">Batch</th>

                                <th style=" text-align: center;"> Duration </th>

                                <th style=" text-align: center;"> Admission Date </th>

                                <th style=" text-align: center;">Installment Type</th>

                                <th style=" text-align: center;"> Status </th>
                                
                                <th style=" text-align: center;">Option</th>


                            </tr>

                        </thead>

                        <tbody>

                            @foreach($data as $s_course)

                            @if($s_course->late_fee != 0)

                            <tr style="color: red;">

                                @else

                            <tr>

                                @endif

                                <td width="12%">{{ $s_course->course_name }}</td>

                                <td width="15%" style=" text-align: center;">{{ $batch->find($s_course->batch_id)->name }}</td>
                              
                                <td width="12%" style=" text-align: center;">{{ $course->find($branch_course->find($s_course->branch_course_id)->course_id)->duration }} Months</td>

                                <td width="18%" style=" text-align: center;">{{$s_course->admission_date}}</td>
                                <td  width="18%"style=" text-align: center;">{{$s_course->installment}}</td>

                                @if($s_course->c_status == 'Complete')

                                <td width="15%" style=" color: green ; text-align: center;"><b>{{$s_course->c_status}}</b></td>

                                @elseif($s_course->c_status == 'Incomplete')

                                <td width="15%" style=" color: red ; text-align: center;"><b>{{$s_course->c_status}}</b></td>

                                @else

                                <td width="15%" style=" color: teal ; text-align: center;"><b>{{$s_course->c_status}}</b></td>

                                @endif

                                <td width="10%" style=" text-align: center;">

                                    <a href="{{ Asset($link.'course-details/'.$s_course->id.'/view') }}" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="View Details" style="padding:0px 10px"><i class="fa fa-info-circle"></i></a>


                                    @if($s_course->c_status == 'Ongoing')

                                    <a href="{{ Asset($link.'changebatch/'.$s_course->id) }}" class="btn cyan tooltipped " data-position="top" data-delay="50" data-tooltip="Change Batch" style="padding:0px 10px"><i class="mdi-action-cached"></i></a>

                                   <form action="{{ Asset($link.'stop-course/'.$s_course->id) }}" method="POST" id="restore_form_{{ $s_course->id }}" class="form-inline">

                                        @csrf
                                        @method('PATCH')

                                        <button type="button" class="btn red tooltipped " data-position="top" data-delay="50" data-tooltip="Stop This Course" style="padding:0px 10px" onclick="confirmAlert('stop',this)"><i class="fa fa-power-off"></i></button>

                                    </form>
                                    @endif

                                </td>

                            </tr>



                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection