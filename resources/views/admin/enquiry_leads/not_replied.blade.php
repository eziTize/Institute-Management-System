@extends('admin.layout.main')
@section('title') Manage Enquiry Leads Not Replied within 24 Hours @endsection

@section('content')
<div class="container">
    <div class="section">
        @section('button')
        <a href="{{ Asset($link) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">List</a>
        @endsection

        <form action="{{ Asset($link.'not_replied') }}" autocomplete="off">
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
                    <table class="striped" >
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Phone</th>
                                <th>Enquiry Source</th>
                                <th>Course</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $enquiry_lead)
                            <tr>
                                <td width="15%">{{ ($enquiry_lead->student_name) ?? '-' }}</td>
                                <td width="15%">{{ $enquiry_lead->phone }}</td>
                                <td width="15%">{{ $single_enquiry_src->find($enquiry_lead->enquiry_src)->name }}</td>
                                <td width="15%">{{ $single_course->find($enquiry_lead->course)->name }}</td>
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