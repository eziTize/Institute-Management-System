@extends('admin.layout.main')

@section('title') Manage Course @endsection



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

                                <th>Name</th>

                                <th>Duration(Month)</th>

                                <th>Status</th>

                                <th>Option</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($data as $course)

                            <tr>

                                <td width="30%">{{ $course->name }}</td>

                                <td width="30%">{{ $course->duration }}</td>

                                <td width="15%">{!! IMS::status($course->status) !!}</td>

                                <td width="25%">

                                    <a href="{{ Asset($link.$course->id.'/edit') }}" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="Edit This Entry" style="padding:0px 10px"><i class="mdi-editor-mode-edit"></i></a>

                                    <form action="{{ Asset($link.$course->id) }}" method="POST" id="delete_form_{{ $course->id }}" class="form-inline">

                                        @csrf

                                        @method('DELETE')

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