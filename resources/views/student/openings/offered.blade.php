@extends('student.layout.main')

@section('title') Job Offers @endsection



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

                                <th style="text-align: center;">Joining Date</th>
                                                        
                                <th style="text-align: center;">Option</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($data as $op_students)

                            <tr>

                                <td width="25%"> {{ $openings->find($op_students->openings_id)->company_name }} </td>

                                <td style="text-align: center;" width="30%">{{ $openings->find($op_students->openings_id)->o_type }}</td>

                                <td style="text-align: center;" width="25%"> {{ $op_students->join_date }} </td>


                                <td style="text-align: center;" width="20%">

                                    <a href="{{ Asset($link.$op_students->id.'/download-letter') }}" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="Download Offer Letter" style="padding:0px 10px"><i class="mdi-file-file-download"></i></a>

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