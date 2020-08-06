@extends('branch.layout.main')
@section('title') Manage Course @endsection

@section('content')
<div class="container">
    <div class="section">
        @section('button')
        @endsection

        <div id="striped-table">
            <div class="row">
                <div class="col s12 m12 l12">
                    <table class="striped" >
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Duration(Month)</th>
                                <th>Fee(Rs)</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $branch_course)
                            <tr>
                                <td width="15%">{{ $course->find($branch_course->course_id)->name }}</td>
                                <td width="20%">{{ $course->find($branch_course->course_id)->duration }}</td>
                                <td width="25%">{{ $branch_course->fee }}</td>
                                <td width="15%">{!! IMS::status($branch_course->status) !!}</td>
                                <td width="25%">
                                    <a href="{{ Asset($link.$branch_course->id.'/edit') }}" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="View This Entry" style="padding:0px 10px"><i class="mdi-action-visibility"></i></a>
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