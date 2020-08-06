@extends('tpo.layout.main')

@section('title') Manage Openings @endsection



@section('content')

<div class="container">

    <div class="section">

        @section('button')

        <a href="{{ Asset($link.'add') }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">Add New</a>

        @endsection



        <div id="striped-table">

            <div class="row">

                <div class="col s12 m12 l12">

                    <table class="striped" >

                        <thead>

                            <tr>

                                <th>Company Name</th>

                                <th>Opening Type</th>

                                <th>Interview date</th>
                                
                                <th>Intake Capacity</th>

                                <th>Status</th>
                                
                                <th>Option</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($data as $openings)

                            <tr>

                                <td width="18%"> {{ $openings->company_name }} </td>

                                <td width="18%">{{ $openings->o_type }}</td>

                                <td width="19%"> {{$openings->date }} </td>

                                <td width="15%"> {{$openings->intake_cap }} </td>

                                
                                @if( $openings->is_active == 1 )
                                <td width="12%" style="color: green" > Active </td>
                                @else
                                <td width="12%" style="color: red"> Inactive </td>
                                @endif


                                <td width="18%">

                                    <a href="{{ Asset($link.$openings->id.'/applications') }}" class="btn teal tooltipped " data-position="top" data-delay="50" data-tooltip="View applications" style="padding:0px 10px"><i class="fa fa-file-text"></i></a>



                                    <a href="{{ Asset($link.$openings->id.'/edit') }}" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="Edit This Entry" style="padding:0px 10px"><i class="mdi-editor-mode-edit"></i></a>


                                     <form action="{{ Asset($link.'destroy/'.$openings->id) }}" method="POST" id="restore_form_{{ $openings->id }}" class="form-inline">

                                        @csrf
                                        @method('PATCH')

                                        <button type="button" class="btn red tooltipped " data-position="top" data-delay="50" data-tooltip="Delete This Entry" style="padding:0px 10px" onclick="confirmAlert('destroy',this)"><i class="mdi-content-clear"></i></button>

                                    </form>


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