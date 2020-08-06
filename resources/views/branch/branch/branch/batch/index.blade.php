@extends('branch.layout.main')
@section('title') Manage Batch @endsection

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
                                <th>Course</th>
                                <th>Batch Name</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $batch)
                            <tr>
                                <td width="35%">
                                    {{ $batch->batchView($batch->id)->course_name }} - Fee: {{ $batch->batchView($batch->id)->fee }}
                                </td>
                                <td width="25%">{{ $batch->name }}</td>
                                <td width="15%">{!! IMS::status($batch->status) !!}</td>
                                <td width="25%">
                                    <a href="{{ Asset($link.$batch->id.'/edit') }}" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="View This Entry" style="padding:0px 10px"><i class="mdi-action-visibility"></i></a>
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