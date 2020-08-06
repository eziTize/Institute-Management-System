@extends('branch.layout.main')
@section('title') Manage Enquiry Leads @endsection

@section('content')
<div class="container">
    <div class="section">
        @section('button')
        <a href="{{ Asset($link.'add') }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">Add New</a>
        <a href="#excelUpload" class="btn blue waves-effect waves-light right modal-trigger" style="margin-top:25px;margin-right:5px">Upload Excel</a>
        @include('branch.enquiry_leads.excel',['link' => $link])
        @endsection

        <div id="striped-table">
            <div class="row">
                <div class="col s12 m12 l12">
                    <table class="striped" >
                        <thead>
                            <tr>
                                <th>Phone</th>
                                <th>Enquiry Source</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $enquiry_lead)
                            <tr>
                                <td width="35%">{{ $enquiry_lead->phone }}</td>
                                <td width="25%">{{ $enquiry_src->find($enquiry_lead->enquiry_src)->name }}</td>
                                <td width="15%">{!! IMS::enq_status($enquiry_lead->status) !!}</td>
                                <td width="25%">
                                    @if($enquiry_lead->called_by)
                                    <a href="#feedback-{{ $enquiry_lead->id }}" class="btn cyan tooltipped modal-trigger " data-position="top" data-delay="50" data-tooltip="Feedback" style="padding:0px 10px"><i class="mdi-action-speaker-notes"></i></a>
                                    @include('admin.enquiry_leads.feedback')
                                    @else
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