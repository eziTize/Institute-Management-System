@extends('admin.layout.main')
@section('title') Manage Tpo / Company HR @endsection

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
                                <?php /*<th>Branch</th> /* As of now Tpo is not dependent on branch */ ?>
                                <th>Tpo / Company HR Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $tpo)
                            <tr>
                                <?php /*<td width="20%">{{ $branch->find($tpo->branch_id)->name }}</td> /* As of now Tpo is not dependent on branch */ ?>
                                <td width="30%">{{ $tpo->name }}</td>
                                <td width="30%">{{ $tpo->email }}</td>
                                <td width="15%">{!! IMS::status($tpo->status) !!}</td>
                                <td width="25%">
                                    <form action="{{ Asset(env('tpo').'/loginWithID/'.$tpo->id) }}" method="POST" target="_blank" class="form-inline">
                                        @csrf
                                        <button type="submit" class="btn cyan tooltipped " data-position="top" data-delay="50" data-tooltip="Login as {{ $tpo->name }}" style="padding:0px 10px"><i class="fa fa-sign-in"></i></button>
                                    </form>
                                    <a href="{{ Asset($link.$tpo->id.'/edit') }}" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="Edit This Entry" style="padding:0px 10px"><i class="mdi-editor-mode-edit"></i></a>
                                    <form action="{{ Asset($link.$tpo->id) }}" method="POST" id="delete_form_{{ $tpo->id }}" class="form-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn red tooltipped " data-position="top" data-delay="50" data-tooltip="Delete This Entry" style="padding:0px 10px" onclick="confirmAlert('destroy',this)"><i class="mdi-content-clear"></i></button>
                                    </form>
                                    @if($task->where('tpo_id',$tpo->id)->where('status','0')->exists())
                                    <a href="{{ Asset($link.$tpo->id.'/add_task') }}" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="Modify Task" style="padding:0px 10px"><i class="mdi-action-assignment"></i></a>
                                    @if($task->where('tpo_id',$tpo->id)->where('status','0')->where('finish_request','1')->exists())
                                    <form action="{{ Asset($link.$tpo->id.'/finish_task') }}" method="POST" id="finish_form_{{ $tpo->id }}" class="form-inline">
                                        @csrf
                                        <button type="button" class="btn green tooltipped" data-position="top" data-delay="50" data-tooltip="Finish Task" style="padding:0px 10px" onclick="confirmAlert('finish',this)"><i class="mdi-navigation-check"></i></button>
                                    </form>
                                    @endif
                                    @else
                                    <a href="{{ Asset($link.$tpo->id.'/add_task') }}" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="Add Task" style="padding:0px 10px"><i class="mdi-action-assignment"></i></a>
                                    @endif
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