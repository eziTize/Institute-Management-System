@extends('student.layout.main')

@section('title') Opening Details @endsection



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

                                <th  width="50%"> Posted at  </th>

                                 <td  width="50%" style="font-weight: bold;"> {{($data->created_at)->format('d-m-Y') }} </td>


                            </tr>

                        </thead>

                    <tbody>



                        <tr>

                                <td >Company Name</td>

                                <td> {{$data->company_name}}  </td>


                        </tr>



                          <tr>

                                <td >Company Details</td>

                                <td> {{ $data->company_details }} </td>


                            </tr>


                            <tr>

                                <td >Opening Type</td>

                                <td> {{ $data->o_type }} </td>


                            </tr>



                        

                            <tr>

                                <td >Opening Details</td>

                                <td> {{ $data->o_details }} </td>


                            </tr>



                             <tr>

                                <td >Eligibility Criteria</td>

                                <td> {{ $data->eligibility }} </td>


                            </tr>



                            <tr>

                                <td >Salary Range </td>

                                <td> Max: {{ $data->max_salary }} INR <br>  Min: {{ $data->min_salary }} INR </td>


                            </tr>

                            
                            <tr>

                                <td >Intake Capacity</td>

                                <td> {{ $data->intake_cap }} </td>


                            </tr>



                             <tr>

                                <td >Contact Number</td>

                                <td> {{ $data->contact }} </td>


                            </tr>
                            



                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection