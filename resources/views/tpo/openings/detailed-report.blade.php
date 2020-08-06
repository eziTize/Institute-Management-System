@extends('tpo.layout.main')

@section('title') Detailed Placement Report @endsection



@section('content')

<div class="container">

    <div class="section">

        @section('button')


         <a href="{{ Asset($link) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px;margin-right:5px;">  Back </a>



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

                                <th> Offer Sent </th>


                            </tr>

                        </thead>

                        <tbody>



                            @foreach($data as $op_student)


                            <tr>



                                <td width="15%"> {{ $student->find($op_student->student_id)->name }} </td>

                                <td width="25%">{{ $opening->find($op_student->openings_id)->o_type }}</td>


                                @if($op_student->selected == 'Yes')

                                <td width="15%" style="color: green"> Yes </td>


                                @elseif($op_student->selected == 'No')

                                <td width="15%" style="color: red"> No </td>


                                @else

                                <td width="15%" style="color: orange"> Pending </td>

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


                                 @if($op_student->offer == 'Sent')

                                <td width="10%" style="color: green">  Yes </td>


                                @else
                                
                                <td width="10%" style="color: orange">  No </td>


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