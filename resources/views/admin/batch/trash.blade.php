@extends('admin.layout.main')
@section('title') Batch Trash @endsection

@section('content')
<div class="container">
    <div class="section">
        @section('button')
        <a href="{{ Asset($link) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">List</a>
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
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $batch)
                            <tr>
                                <td width="25%">{{ $batch->batchView($batch->id)->branch_name }}</td>
                                <td width="25%">
                                    {{ $batch->batchView($batch->id)->course_name }} - Fee: {{ $batch->batchView($batch->id)->fee }}
                                </td>
                                <td width="25%">{{ $batch->name }}</td>
                                <td width="25%">
                                    <form action="{{ Asset($link.'restore/'.$batch->id) }}" method="POST" id="restore_form_{{ $batch->id }}" class="form-inline">
                                        @csrf
                                        <button type="button" class="btn cyan tooltipped " data-position="top" data-delay="50" data-tooltip="Restore This Entry" style="padding:0px 10px" onclick="confirmAlert('restore',this)"><i class="fa fa-undo"></i></button>
                                    </form>
                                    <form action="{{ Asset($link.'destroy_permanent/'.$batch->id) }}" method="POST" id="delete_form_{{ $batch->id }}" class="form-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn red tooltipped " data-position="top" data-delay="50" data-tooltip="Delete This Entry" style="padding:0px 10px" onclick="confirmAlert('destroy_permanent',this)"><i class="mdi-content-clear"></i></button>
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