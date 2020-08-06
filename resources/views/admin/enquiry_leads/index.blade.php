@extends('admin.layout.main')
@section('title') Manage Enquiry Leads @endsection

@section('content')
<div class="container">
    <div class="section">
        @section('button')
        <a href="{{ Asset($link.'not_replied') }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">Not Replied within 24 Hours</a>
        @endsection

        <form action="{{ Asset($link) }}" autocomplete="off">
            <div class="card-panel">
                <div class="row">
                    <div class="col s6 l10">
                        <div class="col s6 l3">
                            <input type="text" name="phone" placeholder="Phone" value="{{ ($_GET['phone']) ?? null }}">
                        </div>
                        
                        <div class="col s6 l3">
                            <select name="enquiry_src" class="browser-default">
                                <option value="">All Enquiry Source</option>
                                @foreach($enquiry_src as $enq)
                                <option value="{{ $enq->id }}" @if(isset($_GET['enquiry_src']) && $_GET['enquiry_src'] == $enq->id) selected @endif>{{ $enq->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col s6 l3">
                            <select name="course" class="browser-default">
                                <option value="">All Course</option>
                                @foreach($course as $crs)
                                <option value="{{ $crs->id }}" @if(isset($_GET['course']) && $_GET['course'] == $crs->id) selected @endif>{{ $crs->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col s6 l3">
                            <select name="status" class="browser-default">
                                <option value="">All Status</option>
                                <option value="0" @if(isset($_GET['status']) && $_GET['status'] == "0") selected @endif>Not Assigned</option>
                                <option value="1" @if(isset($_GET['status']) && $_GET['status'] == "1") selected @endif>Assigned</option>
                                <option value="2" @if(isset($_GET['status']) && $_GET['status'] == "2") selected @endif>Called</option>
                                <option value="3" @if(isset($_GET['status']) && $_GET['status'] == "3") selected @endif>Walked In</option>
                                <option value="4" @if(isset($_GET['status']) && $_GET['status'] == "4") selected @endif>Admitted</option>
                            </select>
                        </div>
                    </div>

                    <div class="col s6 l2">
                        <button type="submit" name="filter" class="btn yellow darken-4" style="margin-top:10px">Filter</button>
                    </div>
                </div>
            </div>
        </form>

        <div id="striped-table">
            <div class="row">
                <div class="col s12 m12 l12">
                    <table class="striped" >
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Phone</th>
                                <th>Enquiry Source</th>
                                <th>Course</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $enquiry_lead)
                            <tr>
                                <td width="15%">{{ ($enquiry_lead->student_name) ?? '-' }}</td>
                                <td width="15%">{{ $enquiry_lead->phone }}</td>
                                <td width="15%">{{ $single_enquiry_src->find($enquiry_lead->enquiry_src)->name }}</td>
                                <td width="15%">{{ $single_course->find($enquiry_lead->course)->name }}</td>
                                <td width="15%">{!! IMS::enq_status($enquiry_lead->status) !!}</td>
                                <td width="25%">
                                    @if($enquiry_lead->status > 1)
                                    <a href="#feedback-{{ $enquiry_lead->id }}" class="btn cyan tooltipped modal-trigger " data-position="top" data-delay="50" data-tooltip="Feedback" style="padding:0px 10px"><i class="mdi-action-speaker-notes"></i></a>
                                    @include('admin.enquiry_leads.feedback')
                                    @else
                                    <a href="#assign-{{ $enquiry_lead->id }}" class="btn cyan tooltipped modal-trigger " data-position="top" data-delay="50" data-tooltip="Assign" style="padding:0px 10px"><i class="mdi-social-person-add"></i></a>
                                    @include('admin.enquiry_leads.assign')
                                    <a href="{{ Asset($link.$enquiry_lead->id.'/edit') }}" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="Edit This Entry" style="padding:0px 10px"><i class="mdi-editor-mode-edit"></i></a>
                                    <form action="{{ Asset($link.$enquiry_lead->id) }}" method="POST" id="delete_form_{{ $enquiry_lead->id }}" class="form-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn red tooltipped " data-position="top" data-delay="50" data-tooltip="Delete This Entry" style="padding:0px 10px" onclick="confirmAlert('destroy',this)"><i class="mdi-content-clear"></i></button>
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