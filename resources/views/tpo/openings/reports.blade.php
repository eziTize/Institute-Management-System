@extends('tpo.layout.main')

@section('title') Placement Reports @endsection



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

                                <th>Opening Type</th>

                                <th>Interview date</th>

                                <th>Status</th>
                                
                                <th>Option</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($data as $openings)

                            <tr>

                                <td width="20%"> {{ $openings->company_name }} </td>

                                <td width="20%">{{ $openings->o_type }}</td>

                                <td width="20%"> {{$openings->date }} </td>
                                
                                @if( $openings->is_active == 1 )
                                <td width="20%" style="color: green" > Active </td>
                                @else
                                <td width="20%" style="color: red"> Inactive </td>
                                @endif


                                <td width="20%">

                                    <a href="{{ Asset($link.$openings->id.'/view') }}" class="btn teal tooltipped " data-position="top" data-delay="50" data-tooltip="View Report" style="padding:0px 10px"><i class="fa fa-share-square-o"></i></a>

                                    <a href="{{ Asset($link.$openings->id.'/details') }}" class="btn purple tooltipped " data-position="top" data-delay="50" data-tooltip="Detailed Report" style="padding:0px 10px"><i class="fa fa-file"></i></a>


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