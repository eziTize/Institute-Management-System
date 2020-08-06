@extends('branch.layout.main')
@section('title') Generate ID Card @endsection

@section('css')
<link rel="stylesheet" href="{{ Asset('css/custom/student_id_card.css') }}" type="text/css">
<style>
	.header-part{
		width: 100%;
		height:auto;
		float: left;
		background: url("{{ Asset('images/custom/student_id_card/top-blue.png') }}");
		background-repeat: no-repeat;
		margin-bottom: 35px;
	}

	.footer-section{
		width: 100%;
		height:auto;
		overflow: hidden;
		background: url("{{ Asset('images/custom/student_id_card/footer-blue.png') }}");
		background-repeat: no-repeat;
		padding-top: 115px;
		padding-top: 115px;
	}
</style>
@endsection

@section('content')
<div class="container">
    <div class="section">
        @section('button')
        <a href="{{ Asset($link) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px">List</a>
		@if($data->photograph && $data->blood_group)
        	<a href="{{ Asset($link.'getIDCard/'.$data->id) }}" class="btn cyan waves-effect waves-light right" style="margin-top:25px;margin-right:5px;">Get ID Card</a>
        @endif
        @endsection

		<div class="row">
        	<div class="col s12 m12 l12">
            	{!! Form::model($data, ['url' => [env('branch').'/student/generateIDCard/'.$data->id],'files' => true,'autocomplete' => 'off'],['class' => 'col s12']) !!}
				<div class="row">
					<div class="input-field col s12 l6">
						<i class="mdi-social-person prefix"></i>
						{!! Form::text('name',null,['id' => 'name','required' => 'required']) !!}
						<label for="name">Student Name *</label>
					</div>

					<div class="input-field col s12 l6">
						<i class="mdi-action-group-work prefix"></i>
						{!! Form::text('blood_group',null,['id' => 'blood_group','required' => 'required']) !!}
						<label for="blood_group">Blood Group *</label>
					</div>
				</div>

				<div class="row">
					<div class="input-field col s12 l6">
						<i class="mdi-social-person prefix"></i>
						{!! Form::text('id',null,['id' => 'id','disabled' => 'disabled']) !!}
						<label for="id">Unique ID *</label>
					</div>

					<div class="input-field col s12 l6">
						<i class="mdi-action-grade prefix"></i>
						<input type="text" id="valid_till" value="{{ $student_course->course_complete }}" disabled>
						<label for="valid_till">Valid Till *</label>
					</div>
				</div>

				<div class="row">
					<div class="file-field input-field col s12">
		        		<div class="btn">
		            		<span>Select ID Photo</span>
		            		<input type="file" id="id_photo_{{ $data->id }}" name="photograph" @if(!$data->photograph) required @endif onchange="checkextension('{{ $data->id }}')">
		        		</div>
		        		<div class="file-path-wrapper">
		            		<input class="file-path validate" type="text" placeholder="Select">
		        		</div>
		    		</div>
				</div>

				<div class="row">
					<div class="input-field col s12">
						<span id="pic_preview_{{ $data->id }}">
							@if($data->photograph)
							<img src="{{ Asset('upload/student/'.$data->photograph) }}" style="height:240px;width:200px;">
							@endif
						</span>
					</div>
				</div>

				<div class="row">
					<div class="input-field col s12">
						<div class="input-field col s12">
							<button class="btn cyan waves-effect waves-light right" type="submit" name="action">Submit <i class="mdi-content-send right"></i></button>
						</div>
					</div>
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
                    document.querySelector('#pic_preview_'+enq_id).innerHTML = "<img src=\""+event.target.result+"\" style=\"height:240px;width:200px;\">";
                };

              reader.readAsDataURL(file.files[0]);
            }
        }else{
            document.querySelector('#pic_preview_'+enq_id).innerHTML = "";
        }
    }
</script>
@endsection