@extends('telecaller.layout.main')
@section('title') Manage Enquiry Leads @endsection

@section('content')
<div class="container">
    <div class="section">
        @section('button')
        @endsection

        <form action="{{ Asset($link) }}" autocomplete="off">
            <div class="card-panel">
                <div class="row">
                    <div class="col s6 l10">
                        <div class="col s6 l4">
                            <input type="text" name="phone" placeholder="Phone" value="{{ ($_GET['phone']) ?? null }}">
                        </div>
                        
                        <div class="col s6 l4">
                            <select name="enquiry_src" class="browser-default">
                                <option value="">All Enquiry Source</option>
                                @foreach($enquiry_src as $enq)
                                <option value="{{ $enq->id }}" @if(isset($_GET['enquiry_src']) && $_GET['enquiry_src'] == $enq->id) selected @endif>{{ $enq->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col s6 l4">
                            <select name="course" class="browser-default">
                                <option value="">All Course</option>
                                @foreach($course as $crs)
                                <option value="{{ $crs->id }}" @if(isset($_GET['course']) && $_GET['course'] == $crs->id) selected @endif>{{ $crs->name }}</option>
                                @endforeach
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
                    @if($type == 'assigned')
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
                                    <a href="#feedbackPost-{{ $enquiry_lead->id }}" class="btn cyan tooltipped modal-trigger " data-position="top" data-delay="50" data-tooltip="Give Feedback" style="padding:0px 10px"><i class="mdi-action-speaker-notes"></i></a>
                                    @include('telecaller.enquiry_leads.feedbackPost')
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @elseif($type == 'called')
                    <table class="striped" >
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Phone</th>
                                <th>Enquiry Source</th>
                                <th>Course</th>
                                <th>Lead Quality</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $enquiry_lead)
                            <tr>
                                <td width="15%">{{ $enquiry_lead->student_name }}</td>
                                <td width="15%">{{ $enquiry_lead->phone }}</td>
                                <td width="10%">{{ $enquiry_src->find($enquiry_lead->enquiry_src)->name }}</td>
                                <td width="15%">{{ $single_course->find($enquiry_lead->course)->name }}</td>
                                <td width="15%">{{ $single_lead_quality->find($enquiry_lead->lead_quality)->name }}</td>
                                <td width="10%">{!! IMS::enq_status($enquiry_lead->status) !!}</td>
                                <td width="20%">
                                    <a href="#feedbackPost-{{ $enquiry_lead->id }}" class="btn cyan tooltipped modal-trigger " data-position="top" data-delay="50" data-tooltip="Give Feedback" style="padding:0px 10px"><i class="mdi-action-speaker-notes"></i></a>
                                    @include('telecaller.enquiry_leads.feedbackPost')

                                    <a href="#makeWalkIn-{{ $enquiry_lead->id }}" class="btn green tooltipped modal-trigger " data-position="top" data-delay="50" data-tooltip="Make Walked In" style="padding:0px 10px"><i class="mdi-action-assignment-turned-in"></i></a>
                                    @include('telecaller.enquiry_leads.makeWalkIn')
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @elseif($type == 'walked_in')
                    <table class="striped" >
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Photo ID</th>
                                <th>Phone</th>
                                <th>Enquiry Source</th>
                                <th>Course</th>
                                <th>Lead Quality</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $enquiry_lead)
                            <tr>
                                <td width="10%">{{ $enquiry_lead->student_name }}</td>
                                <td width="15%">
                                    <img src="{{ Asset('upload/walkin/'.$enquiry_lead->id_photo) }}" style="height:100px;">
                                </td>
                                <td width="15%">{{ $enquiry_lead->phone }}</td>
                                <td width="10%">{{ $enquiry_src->find($enquiry_lead->enquiry_src)->name }}</td>
                                <td width="15%">{{ $single_course->find($enquiry_lead->course)->name }}</td>
                                <td width="15%">{{ $single_lead_quality->find($enquiry_lead->lead_quality)->name }}</td>
                                <td width="10%">{!! IMS::enq_status($enquiry_lead->status) !!}</td>
                                <td width="10%">
                                    <a href="#makeAdmission-{{ $enquiry_lead->id }}" class="btn green tooltipped modal-trigger " data-position="top" data-delay="50" data-tooltip="Make Admission" style="padding:0px 10px"><i class="mdi-action-assignment-turned-in"></i></a>
                                    @include('telecaller.enquiry_leads.makeAdmission')
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <table class="striped" >
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Photo ID</th>
                                <th>Phone</th>
                                <th>Enquiry Source</th>
                                <th>Course</th>
                                <th>Lead Quality</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $enquiry_lead)
                            <tr>
                                <td width="10%">{{ $enquiry_lead->student_name }}</td>
                                <td width="15%">
                                    <img src="{{ Asset('upload/walkin/'.$enquiry_lead->id_photo) }}" style="height:100px;">
                                </td>
                                <td width="15%">{{ $enquiry_lead->phone }}</td>
                                <td width="10%">{{ $enquiry_src->find($enquiry_lead->enquiry_src)->name }}</td>
                                <td width="15%">{{ $single_course->find($enquiry_lead->course)->name }}</td>
                                <td width="15%">{{ $single_lead_quality->find($enquiry_lead->lead_quality)->name }}</td>
                                <td width="10%">{!! IMS::enq_status($enquiry_lead->status) !!}</td>
                                <td width="10%">
                                    <a href="#makeAdmission-{{ $enquiry_lead->id }}" class="btn green tooltipped modal-trigger " data-position="top" data-delay="50" data-tooltip="Make Admission" style="padding:0px 10px"><i class="mdi-action-assignment-turned-in"></i></a>
                                    @include('telecaller.enquiry_leads.makeAdmission')
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function checkextension(enq_id){
        var file = document.querySelector("#id_photo_"+enq_id);
        if(file.files[0]){
            if(/\.(jpg|jpeg|png)$/i.test(file.files[0].name) === false){
                swal("File format not supported", "Supported Formats: jpg/jpeg/png.");
                document.querySelector("#id_photo_"+enq_id).value = "";
                document.querySelector('#pic_preview_'+enq_id).innerHTML = "";
            }else{
                var reader = new FileReader();

                reader.onload = function(event){
                    document.querySelector('#pic_preview_'+enq_id).innerHTML = "<img src=\""+event.target.result+"\" style=\"width:100%;\">";
                };

              reader.readAsDataURL(file.files[0]);
            }
        }else{
            document.querySelector('#pic_preview_'+enq_id).innerHTML = "";
        }
    }
</script>
@endsection