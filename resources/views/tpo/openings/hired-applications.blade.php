@extends('tpo.layout.main')

@section('title') Hired Applicants @endsection



@section('content')

<div class="container">

    <div class="section">

        @section('button')




        <a href="{{ Asset($link.$opening->id.'/applications/selected') }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px; margin-right:5px;">Selected </a>

        <a href="{{ Asset($link.$opening->id.'/applications/interviewed') }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px;margin-right:5px;">  Interviewed </a>

        <a href="{{ Asset($link.$opening->id.'/applications') }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px; margin-right:5px"> All </a>




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

                                <th> Interview Date </th>

                                <th> Options </th>


                            </tr>

                        </thead>

                        <tbody>



                            @foreach($data as $op_student)


                            <tr>



                                <td width="15%"> {{ $student->find($op_student->student_id)->name }} </td>

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



                                <td width="15%">{{ $op_student->interview_date }}</td>


                                @if($op_student->offer == 'Sent')

                                <td width="10%" style="color: green">  Offer Sent </td>


                                @else
                                
                                 <td width="10%">


                                    <a href="{{ Asset($link.$op_student->id.'/send-offer') }}" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="Send Offer" style="padding:0px 10px"><i class="fa fa-envelope"></i></a>

                                </td>


                                @endif





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