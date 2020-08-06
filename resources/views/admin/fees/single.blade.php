@extends('admin.layout.main')

@section('title'){{ $student->find($data->student_id)->name }}'s Fee @endsection



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

                                <th >Fee Date</th>

                                <th> {{$data->fee_date}} </th>


                            </tr>

                        </thead>

                    <tbody>



                    <tr>

                         <td > Student Name </td>

                        <td> {{ $student->find($data->student_id)->name }} </td>


                     </tr>

                    <tr>

                         <td > Fee Paid </td>

                        <td> {{ $data->fee }}</td>


                     </tr>




                      <tr>

                         <td > Fee Description  </td>

                        <td> {{ $data->description }} </td>


                     </tr>



                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection