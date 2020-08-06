@extends('student.layout.main')

@section('title') Available Openings @endsection



@section('content')

<div class="container">

    <div class="section">


        <div id="striped-table">

            <div class="row">

                <div class="col s12 m12 l12">

                    <table class="striped" >

                        <thead>

                            <tr>

                                <th>Company Name</th>

                                <th style="text-align: center;">Opening Type</th>

                                <th style="text-align: center;">Posted at</th>
                                
                                <th style="text-align: center;">Intake</th>
                                
                                <th style="text-align: center;">Option</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($data as $openings)

                            <tr>

                                <td width="20%"> {{ $openings->company_name }} </td>

                                <td style="text-align: center;" width="25%">{{ $openings->o_type }}</td>

                                <td style="text-align: center;" width="20%"> {{($openings->created_at)->format('d-m-Y') }} </td>

                                <td style="text-align: center;" width="15%"> {{$openings->intake_cap }} </td>


                                <td style="text-align: center;" width="20%">

                                    <a href="{{ Asset($link.$openings->id.'/send-application') }}" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="Apply for this Opening" style="padding:0px 10px">Apply</a>


                                     <a href="{{ Asset($link.$openings->id.'/view') }}" class="btn blue tooltipped " data-position="top" data-delay="50" data-tooltip="View this Opening" style="padding:0px 10px">View</a>


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