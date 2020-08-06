@extends('admin.layout.main')
@section('title') Manage Batch @endsection

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
                                <th>Branch</th>
                                <th>Course</th>
                                <th>Batch Name</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $batch)
                            <tr>
                                <td width="15%">{{ $batch->batchView($batch->id)->branch_name }}</td>
                                <td width="30%">
                                    {{ $batch->batchView($batch->id)->course_name }} - Fee: {{ $batch->batchView($batch->id)->fee }}
                                </td>
                                <td width="15%">{{ $batch->name }}</td>
                                <td width="15%">{!! IMS::status($batch->status) !!}</td>
                                <td width="25%">
                                    <a href="{{ Asset($link.$batch->id.'/edit') }}" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="Edit This Entry" style="padding:0px 10px"><i class="mdi-editor-mode-edit"></i></a>
                                    <form action="{{ Asset($link.$batch->id) }}" method="POST" id="delete_form_{{ $batch->id }}" class="form-inline">
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