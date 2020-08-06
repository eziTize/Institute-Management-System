@extends('tpo.layout.main')

@section('title') {{$opening->o_type}}'s Report @endsection



@section('content')

<div class="container">

    <div class="section">

        @section('button')

        <a href="{{ Asset($link) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">Back</a>

        @endsection



        <div id="striped-table">

            <div class="row">

                <div class="col s12 m12 l12">

                    <table class="striped" >

                        <thead>

                            <tr>

                                <th >Company Name</th>

                                <th> {{$opening->company_name}} </th>


                            </tr>

                        </thead>

                    <tbody>



                    <tr>

                         <td > Opening Type </td>

                        <td> {{ $opening->o_type }} </td>


                     </tr>

                    <tr>

                         <td > Total Applications </td>

                        <td> {{ $application_count }}</td>


                     </tr>


                     <tr>

                         <td > Total Selected For Interview </td>

                        <td> {{ $selected_count }}</td>


                     </tr>




                      <tr>

                         <td > Total Interviewed  </td>

                        <td> {{ $interviewed_count}} </td>


                     </tr>



                      <tr>

                         <td > Total Rejected  </td>

                        <td> {{ $rejected_count}} </td>


                     </tr>


                      <tr>

                         <td > Total Hired  </td>

                        <td> {{ $hired_count}} </td>


                     </tr>



                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection