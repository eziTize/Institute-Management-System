@extends('tpo.layout.main')

@section('title') Manage Applications @endsection



@section('content')

<div class="container">

    <div class="section">

        @section('button')


         <a href="{{ Asset($link.$opening->id.'/applications/selected') }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px;margin-right:5px;">  Selected </a>


         <a href="{{ Asset($link.$opening->id.'/applications/interviewed') }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px;margin-right:5px;">  Interviewed </a>


        <a href="{{ Asset($link.$opening->id.'/applications/hired') }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px;margin-right:5px;"> Hired </a>



        @endsection



        <div id="striped-table">

            <div class="row">

                <div class="col s12 m12 l12">

                    <table class="striped" >

                        <thead>

                            <tr>

                                <th>Student Name</th>

                                <th> Applied For</th>

                                <th> Selected </th>
                                
                                <th> Interviewed </th>

                                <th> Hired </th>

                                <th> Options </th>

                            </tr>

                        </thead>

                        <tbody>



                            @foreach($data as $op_student)


                            <tr>



                                <td width="20%"> {{ $student->find($op_student->student_id)->name }} </td>

                                <td width="20%">{{ $opening->find($op_student->openings_id)->o_type }}</td>


                                @if($op_student->selected == 'Yes')

                                <td width="10%" style="color: green"> Yes </td>


                                @elseif($op_student->selected == 'No')

                                <td width="10%" style="color: red"> No </td>


                                @else

                                <td width="10%" style="color: orange"> Pending </td>

                                @endif



                                 @if($op_student->interviewed == 'Yes')

                                <td width="15%" style="color: green"> Yes </td>


                                @elseif($op_student->interviewed == 'No')

                                <td width="15%" style="color: red"> No </td>


                                @else

                                <td width="15%" style="color: orange"> Pending </td>

                                @endif




                                 @if($op_student->hired == 'Yes')

                                <td width="10%" style="color: green"> Yes </td>


                                @elseif($op_student->hired == 'No')

                                <td width="10%" style="color: red"> No </td>


                                @else

                                <td width="10%" style="color: orange"> Pending </td>

                                @endif



                                <td width="20%">



                                     <a href="{{ Asset($link.$op_student->id.'/download-cv') }}" class="btn blue tooltipped " data-position="top" data-delay="50" data-tooltip="Download CV" style="padding:0px 10px"><i class="mdi-file-file-download"></i></a>


                                     @if( $op_student->selected == 'Yes' && $op_student->hired !== 'Yes')


                                    <a href="{{ Asset($link.$op_student->id.'/schedule-interview') }}" class="btn cyan tooltipped " data-position="top" data-delay="50" data-tooltip="Arrange Interview" style="padding:0px 10px"><i class="fa fa-calendar"></i></a>

                                    @endif


                                     @if( $op_student->selected !== 'Yes' )


                                      <form action="{{ Asset($link.$op_student->id.'/select-application') }}" method="POST" id="select_form_{{ $op_student->id }}" class="form-inline">

                                        @csrf
                                        @method('PATCH')

                                        <button type="button" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="Select This Applicant" style="padding:0px 10px" onclick="confirmAlert('select',this)">Select</button>

                                    </form>


                                    @endif


                                    @if( $op_student->selected == 'Pending')



                                     <form action="{{ Asset($link.$op_student->id.'/reject-application') }}" method="POST" id="reject_form_{{ $op_student->id }}" class="form-inline">

                                        @csrf
                                        @method('PATCH')

                                        <button type="button" class="btn red tooltipped " data-position="top" data-delay="50" data-tooltip="Reject This Applicant" style="padding:0px 10px" onclick="confirmAlert('reject',this)">Reject</button>

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