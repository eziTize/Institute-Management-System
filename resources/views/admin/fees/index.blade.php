@extends('admin.layout.main')

@section('title') Manage Fee @endsection



@section('content')

<div class="container">

    <div class="section">

        @section('button')

        <a href="{{ Asset($link.'add') }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">Add New</a>

        <a href="{{ Asset($link.'trash') }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px;margin-right:5px;">View Trash</a>

        @endsection



        <div id="striped-table">

            <div class="row">

                <div class="col s12 m12 l12">

                    <table class="striped" >

                        <thead>

                            <tr>

                                <th >Student Name</th>

                                <th style=" text-align: center;">Fee Description</th>

                                <th style=" text-align: center;">Fee (Rs)</th>

                               
                                <th style=" text-align: center;"> Date </th>

                                
                                <th style=" text-align: center;">Option</th>


                            </tr>

                        </thead>

                        <tbody>

                            @foreach($data as $fees)

                            <tr>

                                <td width="25%">{{ $student->find($fees->student_id)->name }}</td>

                                <td width="25%" style=" text-align: center;">{{ $fees->description }}</td>

                                <td width="15%" style=" text-align: center;">{{  $fees->fee }}</td>

                                <td width="15%" style=" text-align: center;">{{ $fees->fee_date }}</td>

                                

                                <td width="20%" style=" text-align: center;">

                                    <a href="{{ Asset($link.$fees->id.'/view') }}" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="View This Entry" style="padding:0px 10px"><i class="mdi-action-visibility"></i></a>

                                   <form action="{{ Asset($link.'destroy/'.$fees->id) }}" method="POST" id="restore_form_{{ $fees->id }}" class="form-inline">

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