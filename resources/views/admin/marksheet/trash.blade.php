@extends('admin.layout.main')

@section('title') Manage Marksheet @endsection



@section('content')

<div class="container">

    <div class="section">

        @section('button')

       <a href="{{ Asset($link.'add') }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">Add New</a>

        <a href="{{ Asset($link) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px;margin-right:5px;">List</a>

        @endsection


        <div id="striped-table">

            <div class="row">

                <div class="col s12 m12 l12">

                    <table class="striped" >

                        <thead>

                            <tr>

                                <th>Student Name</th>

                                <th style="text-align: center;">Session</th>

                                <th style="text-align: center;">Semester</th>

                                <th style="text-align: center;">Course</th>

                                <th style="text-align: center;">Marksheet No.</th>

                                <th style="text-align: center;"> Options </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($data as $marksheet)

                            <tr>

                                <td width="15%">{{ $student->find($marksheet->student_id)->name }}</td>

                                <td width="20%" style="text-align: center;">{{$marksheet->session}}</td>

                                <td style="text-align: center;" width="10%">{{$marksheet->semester}}</td>


                                <td width="20%" style="text-align: center;">{{$marksheet->course_name}}</td>

                                <td width="15%"  style="text-align: center;" >{{$marksheet->msheet_no}}</td>

                                <td width="20%" style="text-align: center;">

                                    

                                    <form action="{{ Asset($link.'restore/'.$marksheet->id) }}" method="POST" id="restore_form_{{ $marksheet->id }}" class="form-inline">

                                        @csrf
                                        @method('PATCH')

                                        <button type="button" class="btn cyan tooltipped " data-position="top" data-delay="50" data-tooltip="Restore This Entry" style="padding:0px 10px" onclick="confirmAlert('restore',this)"><i class="fa fa-undo"></i></button>

                                    </form>

                                    <form action="{{ Asset($link.'destroy_permanent/'.$marksheet->id) }}" method="POST" id="delete_form_{{ $marksheet->id }}" class="form-inline">

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