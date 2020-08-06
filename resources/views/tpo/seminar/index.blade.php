@extends('tpo.layout.main')

@section('title') Manage Seminar @endsection



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

                                <th>Seminar Date</th>

                                <th>Seminar Name</th>

                                <th>Remarks</th>

                                <th>Option</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($data as $sm)

                            <tr>

                                <td width="15%"> {{ $sm->date }} </td>

                                <td width="30%">{{ $sm->sm_name }}</td>


                                @if($sm->remarks == '' )

                                <td width="30%"> N/A </td>

                                @else

                                <td width="30%"> {{$sm->remarks }} </td>

                                @endif

                                <td width="25%">

                                    <a href="javascript:void(0);" onclick="download_doc({{ $fields->where('seminar_id',$sm->id)->pluck('img_file') }});" class="btn blue tooltipped " data-position="top" data-delay="50" data-tooltip="Download Image(s)" style="padding:0px 10px"><i class="mdi-file-file-download"></i></a>

                                    <a href="{{ Asset($link.$sm->id.'/upload-image') }}" class="btn teal tooltipped " data-position="top" data-delay="50" data-tooltip="Upload Image(s)" style="padding:0px 10px"><i class="fa fa-upload"></i></a>

                                    <a href="{{ Asset($link.$sm->id.'/edit') }}" class="btn green tooltipped " data-position="top" data-delay="50" data-tooltip="Edit This Entry" style="padding:0px 10px"><i class="mdi-editor-mode-edit"></i></a>


                                     <form action="{{ Asset($link.'destroy/'.$sm->id) }}" method="POST" id="restore_form_{{ $sm->id }}" class="form-inline">

                                        @csrf
                                        @method('PATCH')

                                        <button type="button" class="btn red tooltipped " data-position="top" data-delay="50" data-tooltip="Delete This Entry" style="padding:0px 10px" onclick="confirmAlert('destroy',this)"><i class="mdi-content-clear"></i></button>

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

    function download_doc(img_file){

        img_file.forEach(function(doc){

            var file_path = "{{ Asset('upload/seminar_imgs') }}"+"/"+doc;

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