@extends('teacher.layout.main')
@section('title') Task Tracker @endsection

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
                                <th>Description</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $task)
                            <tr>
                                <td width="30%">{{ $task->task_desc }}</td>
                                <td width="15%">{{ date('d M Y',strtotime($task->start_date)) }}</td>
                                <td width="15%">{{ date('d M Y',strtotime($task->end_date)) }}</td>
                                <td width="15%">{!! IMS::task_status($task) !!}</td>
                                <td width="25%">
                                    <a href="#makeComments-{{ $task->id }}" class="btn green tooltipped modal-trigger" data-position="top" data-delay="50" data-tooltip="Make Comments" style="padding:0px 10px"><i class="mdi-action-speaker-notes"></i></a>
                                    @include('teacher.task.makeComments',['link' => $link,'task' => $task])
                                    @if($task->finish_request == 0)
                                    <form action="{{ Asset($link.$task->id.'/finish_task') }}" method="POST" id="finish_form_{{ $task->id }}" class="form-inline">
                                        @csrf
                                        <button type="button" class="btn green tooltipped" data-position="top" data-delay="50" data-tooltip="Finish Task" style="padding:0px 10px" onclick="confirmAlert('finish',this)"><i class="mdi-navigation-check"></i></button>
                                    </form>
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