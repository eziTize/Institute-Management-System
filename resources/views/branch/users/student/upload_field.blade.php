@if(isset($data) && $data->id)



@foreach($fields as $field)



@php($uid = rand(11,999))



<div class="row" id="prev_upload_field_{{ $uid }}">

    <div class="input-field col s12 l5">

        <input type="text" value="{{ $field->doc_type }}" readonly>

        <label for="doc_type_{{ $uid }}">Document Type</label>

    </div>

    

    <div class="file-field input-field col s12 l6">

        <div class="btn">

            <a href="{{ Asset('upload/student_doc/'.$field->doc_file) }}" download><span style="color:white">Download Document</span></a>

        </div>

        <div class="file-path-wrapper">

            <input type="text" value="{{ $field->doc_file }}" readonly>

        </div>

    </div>



    <div class="input-field col s1">

        <a href="javascript:void(0);" style="color:red" onclick="Prev_Remove({{ $field->id }})"><i class="fa fa-trash fa-2x"></i></a>

    </div>

</div>



@endforeach



@endif



@php($uid = rand(11,999))



<div class="row" id="upload_field_{{ $uid }}">

    <div class="input-field col s12 l5">

        {!! Form::text('doc_type[]',null,['id' => 'doc_type_'.$uid]) !!}

        <label for="doc_type_{{ $uid }}">Document Type</label>

    </div>

    

    <div class="file-field input-field col s12 l6">

        <div class="btn">

            <span>Select Document</span>

            <input type="file" name="doc_file[]">

        </div>

        <div class="file-path-wrapper">

            <input class="file-path validate" type="text" placeholder="Select">

        </div>

    </div>



    <div class="input-field col s1">

        <a href="javascript:void(0);" style="color:red" onclick="Remove(upload_field_{{ $uid }})"><i class="fa fa-trash fa-2x"></i></a>

    </div>

</div>