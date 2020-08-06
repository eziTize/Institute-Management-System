@extends('admin.layout.main')
@section('title') Teacher Trash @endsection

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
                                <th>Teacher Name</th>
                                <th>Email</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $teacher)
                            <tr>
                                <td width="25%">{{ $branch->find($teacher->branch_id)->name }}</td>
                                <td width="25%">{{ $teacher->name }}</td>
                                <td width="25%">{{ $teacher->email }}</td>
                                <td width="25%">
                                    <form action="{{ Asset($link.'restore/'.$teacher->id) }}" method="POST" id="restore_form_{{ $teacher->id }}" class="form-inline">
                                        @csrf
                                        <button type="button" class="btn cyan tooltipped " data-position="top" data-delay="50" data-tooltip="Restore This Entry" style="padding:0px 10px" onclick="confirmAlert('restore',this)"><i class="fa fa-undo"></i></button>
                                    </form>
                                    <form action="{{ Asset($link.'destroy_permanent/'.$teacher->id) }}" method="POST" id="delete_form_{{ $teacher->id }}" class="form-inline">
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