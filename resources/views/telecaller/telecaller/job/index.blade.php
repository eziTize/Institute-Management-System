@extends('telecaller.layout.main')
@section('title') Job @endsection

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
                                <th>Job Description</th>
                                <th>Job Deadline</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $job)
                            <tr>
                                <td width="40%">{{ $job->job_desc }}</td>
                                <td width="20%">{{ $job->deadline }}</td>
                                <td width="20%">{!! IMS::job_status($job) !!}</td>
                                <td width="25%">
                                    <a href="#makeComments-{{ $job->id }}" class="btn green tooltipped modal-trigger" data-position="top" data-delay="50" data-tooltip="Make Comments" style="padding:0px 10px"><i class="mdi-action-speaker-notes"></i></a>
                                    @include('telecaller.job.makeComments',['link' => $link,'job' => $job])
                                    @if($job->finish_request == 0)
                                    <form action="{{ Asset($link.$job->id.'/finish_job') }}" method="POST" id="finish_form_{{ $job->id }}" class="form-inline">
                                        @csrf
                                        <button type="button" class="btn green tooltipped" data-position="top" data-delay="50" data-tooltip="Finish Job" style="padding:0px 10px" onclick="confirmAlert('finish',this)"><i class="mdi-navigation-check"></i></button>
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