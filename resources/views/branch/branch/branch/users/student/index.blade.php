@extends('branch.layout.main')

@section('title') Manage Student @endsection



@section('content')

<div class="container">

    <div class="section">

        @section('button')

        <a href="{{ Asset($link.'add') }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">Add New</a>

        @endsection



        <div id="striped-table">

            <div class="row">

                <div class="col s12 m12 l12">

                    <table class="striped" >

                        <thead>

                            <tr>

                                <th>Admission Date</th>

                                <th>Student Name</th>

                                <th>Status</th>

                                <th>Option</th>

                            </tr>

                        </thead> 

                        <tbody>

                            @foreach($data as $student)

                            <tr>

                                <td width="30%">{{ ($student->admission_date) ?? 'Not Admitted' }}</td>

                                <td width="30%">{{ $student->name }}</td>

                                <td width="15%">{!! IMS::status($student->status) !!}</td>

                                <td width="25%">

                                    <a href="javascript:void(0);" onclick="download_doc({{ $fields->where('student_id',$student->id)->pluck('doc_file') }});" class="btn blue tooltipped " data-position="top" data-delay="50" data-tooltip="Download Documents" style="padding:0px 10px"><i class="mdi-file-file-download"></i></a>

                                    <a href="{{ Asset($link.$student->id.'/edit') }}" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="Edit This Entry" style="padding:0px 10px"><i class="mdi-editor-mode-edit"></i></a>

                                    <form action="{{ Asset($link.$student->id) }}" method="POST" id="delete_form_{{ $student->id }}" class="form-inline">

                                        @csrf

                                        @method('DELETE')

                                        <button type="button" class="btn red tooltipped " data-position="top" data-delay="50" data-tooltip="Delete This Entry" style="padding:0px 10px" onclick="confirmAlert('destroy',this)"><i class="mdi-content-clear"></i></button>

                                    </form>

                                    @if(!$student->admission_date)

                                    <a href="{{ Asset($link.'makeAdmission/'.$student->id) }}" class="btn cyan tooltipped " data-position="top" data-delay="50" data-tooltip="Make Admission" style="padding:0px 10px"><i class="mdi-social-person-add"></i></a>

                                    @else

                                    <a href="{{ Asset($link.'changeCourse/'.$student->id) }}" class="btn cyan tooltipped " data-position="top" data-delay="50" data-tooltip="Change Course" style="padding:0px 10px"><i class="mdi-action-cached"></i></a>

                                    <a href="{{ Asset($link.'changeBatch/'.$student->id) }}" class="btn cyan tooltipped " data-position="top" data-delay="50" data-tooltip="Change Batch" style="padding:0px 10px"><i class="mdi-navigation-refresh"></i></a>

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



@section('js')

<script>

    function download_doc(doc_file){

        doc_file.forEach(function(doc){

            var file_path = "{{ Asset('upload/student_doc') }}"+"/"+doc;

            var a = document.createElement('A');

            a.href = file_path;

            a.download = file_path.substr(file_path.lastIndexOf('/') + 1);

            document.body.appendChild(a);

            a.click();

            document.body.removeChild(a);

        });

    }

</script>

@endsection