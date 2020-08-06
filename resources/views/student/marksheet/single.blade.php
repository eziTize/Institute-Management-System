@extends('student.layout.main')

@section('title') Marksheet Details @endsection



@section('content')

<div class="container">

    <div class="section">

        @section('button')

        <a href="{{ Asset($link) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">Back</a>

        @endsection



        <div id="striped-table">

            <div class="row">

                <div class="col s12 m12 l12">

                    <table class="striped">

                        <thead>

                            <tr>

                                <th> Marksheet Number: </th>

                                 <td style="font-weight: bold;"> {{$data->msheet_no}} </td>


                            </tr>

                        </thead>

                <tbody>



                            <tr>

                                <td >Student Name</td>

                                <td> {{ $student->find($data->student_id)->name}} </td>


                            </tr>

                            <tr>

                                <td >Student Roll No.</td>

                                <td> {{$data->roll_no}} </td>


                            </tr>



                             <tr>

                                <td >Student Branch </td>

                                <td> {{$branch->find($student->find($data->student_id)->branch_id)->name}} </td>


                            </tr>


                    <tr>

                         <td > Session </td>

                        <td> {{$data->session}}</td>


                     </tr>


                    <tr>

                                <td >Student Batch </td>

                                <td> {{$batch->find($data->batch_id)->name}} </td>


                    </tr>

                    <tr>

                         <td > Course </td>

                        <td> {{$data->course_name}}</td>


                     </tr>




                      <tr>

                         <td > Semester </td>

                        <td> {{$data->semester}} </td>


                     </tr>



                    <tr>


                         <td >Paper: Mock Test (Written Examination) </td>

                        <td> Full Marks: <b>{{$data->mtwe_fm}}</b> | Marks Obtained: <b>{{$data->mtwe_om}}</b>  </td>

                    </tr>


                    <tr>


                         <td >Paper: Time Sketch (Written Examination) </td>

                        <td> Full Marks: <b>{{$data->tswe_fm}}</b> | Marks Obtained: <b>{{$data->tswe_om}}</b> </td>

                    </tr>


                     <tr>

                         <td >Seasonal Part </td>

                        <td> Full Marks: <b>{{$data->sp_fm}}</b> | Marks Obtained: <b>{{$data->sp_om}}</b> </td>

                    </tr>

                    <tr>

                         <td >Module Total </td>

                        <td> Full Marks: <b> {{$m_total_fm}} </b>  | Marks Obtained: <b> {{$m_total_om}} </b>  </td>

                    </tr>


                    @if($data->viva_om)

                    <tr>

                         <td >Viva</td>

                        <td> Full Marks: <b>{{$data->viva_fm}}</b>  | Marks Obtained: <b>{{$data->viva_om}}</b>  </td>


                     </tr>

                     @endif


                     @if($data->ft_om)

                     <tr>

                         <td >Field Training</td>

                        <td> Full Marks: <b>{{$data->ft_fm}}</b> | Marks Obtained: <b>{{$data->ft_om}}</b> </td>


                     </tr>

                     @endif

                    <tr>

                         <td> Percentage </td>

                        <td>  {{ number_format ($percent, 0)}} </td>


                     </tr>


                     <tr>

                         <td > Grade </td>


                        @if($percent >= 81)

                        <td> O </td>

                        @elseif($percent <81 && $percent>70)

                        <td> A </td>

                        @elseif($percent <71 && $percent>60)

                        <td> A1 </td>

                        @elseif($percent <61 && $percent>55)

                        <td> B </td>

                        @elseif($percent <56 && $percent>50)

                        <td> B1 </td>

                        @elseif($percent <51 && $percent>45)

                        <td> C </td>

                        @elseif($percent <46 && $percent>40)

                        <td> C1 </td>

                        @elseif($percent <41 && $percent>34)

                        <td> D </td>

                        @else

                        <td> D1 </td>


                        @endif


                     </tr>




                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection