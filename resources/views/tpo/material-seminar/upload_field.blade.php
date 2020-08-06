@if(isset($data) && $data->id)



@foreach($fields as $field)



@php($uid = rand(11,999))



<div class="row" id="prev_upload_field_{{ $uid }}">

    <div class="input-field col s12 l5">

        <input type="text" value="{{ $field->img_name }}" readonly>

        <label for="img_name{{ $uid }}">Image Name</label>

    </div>

    

    <div class="file-field input-field col s12 l6">

        <div class="btn">

            <a href="{{ Asset('upload/seminar_imgs/'.$field->img_file) }}" download><span style="color:white">Download Image</span></a>

        </div>

        <div class="file-path-wrapper">

            <input type="text" value="{{ $field->img_file }}" readonly>

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

        {!! Form::text('img_name[]',null,['id' => 'img_name'.$uid, 'required' => 'required']) !!}

        <label for="img_name_{{ $uid }}">Image Name</label>

    </div>

    

    <div class="file-field input-field col s12 l6">

        <div class="btn">

            <span>Select Image</span>

            <input type="file" name="img_file[]" accept=".jpeg,.jpg,.png" id="fupload{{ $uid }}" onchange="checkextension()">


            {{--! Script for Error on non-jpg/jpeg/png files !--}}

            <script>


            function checkextension() {

                var file = document.querySelector("#fupload{{ $uid }}");

                
                         if (/\.(jpg|jpeg|png)$/i.test(file.files[0].name) === false) {

                    swal("File format not supported", "Supported Formats: jpg/jpeg/png.");
                    document.querySelector("#fupload{{ $uid }}").value = "";

                }
           
            }

            </script>


            {{--! End Script !--}}

        </div>

        <div class="file-path-wrapper">

            <input class="file-path validate" type="text" placeholder="Select">

        </div>

    </div>



    <div class="input-field col s1">

        <a href="javascript:void(0);" style="color:red" onclick="Remove(upload_field_{{ $uid }})"><i class="fa fa-trash fa-2x"></i></a>

    </div>

</div>