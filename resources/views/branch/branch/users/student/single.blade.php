@extends('branch.layout.main')

@section('title'){{ $student->find($data->student_id)->name }}'s Admission Details @endsection



@section('content')

<div class="container">

    <div class="section">

        @section('button')

        <a href="{{ Asset($link) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">View List</a>

        <a href="{{ Asset($link.'trash') }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px;margin-right:5px;">View Trash</a>

        @endsection



        <div id="striped-table">

            <div class="row">

                <div class="col s12 m12 l12">

                    <table class="striped" >

                        <thead>

                            <tr>

                                <th >Admission Date</th>

                                <th> {{$data->start_date}} </th>


                            </tr>

                        </thead>

                <tbody>



                    <tr>

                         <td > Batch </td>

                        <td> {{ $batch->find($data->batch_id)->name }} </td>


                     </tr>

                    <tr>

                         <td > Course </td>

                        <td> {{ $course->find($branch_course->find($batch->find($data->batch_id)->branch_course_id)->course_id)->name }}</td>


                     </tr>




                      <tr>

                         <td > Duration </td>

                        <td> {{ $course->find($branch_course->find($batch->find($data->batch_id)->branch_course_id)->course_id)->duration }} Months</td>


                     </tr>


                    <tr>

                         <td >Course Fee </td>

                        <td> Rs. {{ $branch_course->find($batch->find($data->batch_id)->branch_course_id)->fee}} </td>

                    </tr>


                    <tr>

                         <td >Admission Fee </td>

                        <td> Rs. {{$data->admission_fee }} </td>

                    </tr>

                    <tr>

                         <td >Prospectus Fee </td>

                        <td> Rs. {{$data->ppts_fee }} </td>

                    </tr>

                    <tr>

                         <td >Security Deposit </td>

                        <td> Rs. {{$data->sq_deposit }} </td>


                     </tr>


                     <tr>

                         <td >Registration Fee </td>

                        <td> Rs. {{$data->reg_fee }} </td>


                     </tr>


                      <tr>

                         <td >Discount/Scholarship</td>

                        <td> Rs. {{$data->discount }} </td>


                     </tr>

                     <tr>

                         <td >Installment Type</td>

                        <td> {{$data->installment }} </td>


                     </tr>



                     @if ( $data->installment == 'One Time')



                     <tr>

                         <td ><b> One Time Fee </b></td>

                        <td> <b> Rs. {{$data->ot_fee }} </b> </td>


                     </tr>

                 @elseif ( $data->installment == 'Monthly')

                 <tr>

                         <td > <b> Monthly Fee </b> </td>

                        <td> <b> Rs. {{$data->mt_fee }} / Month </b> </td>


                     </tr>


                @else

                 <tr>

                         <td > <b> Weekly Fee </b> </td>

                        <td> <b> Rs. {{$data->wk_fee }} / Week </b> </td>


                     </tr>




             @endif


                 <!---@if($data->late_fee != 0)
                    
                    <tr style="color: red;">

                         <td > <b> Late Fee </b> </td>

                        <td> <b> Rs. {{$data->late_fee }} </b>  

                            <br>


                            <form action="{{ Asset($link.'late-fee/'.$data->id.'/reset') }}" method="POST" id="rest_late_fee_{{ $data->id }}" class="form-inline">

                                        @csrf
                                        @method('POST')

                                        <button type="button" class="btn red tooltipped " data-position="top" data-delay="50" data-tooltip="Reset if paid" style="padding:0px 10px" onclick="confirmAlert('Reset',this)">Reset Late Fee</button>

                            </form>



                        </td>

                     </tr>


                @endif-->

            



                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection