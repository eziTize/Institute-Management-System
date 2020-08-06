<h4 class="header2">Personal Details</h4>



<div class="col s12 m12 l12">

	<div class="card-panel">

		<div class="row">

			<div class="input-field col s12 l12">

				<i class="mdi-social-person prefix"></i>

				{!! Form::text('name',null,['id' => 'name','required' => 'required']) !!}

				<label for="name">Student Name *</label>

			</div>


		</div>



		<div class="row">

			<div class="input-field col s12 l3">

				<i class="mdi-social-person prefix"></i>

				{!! Form::text('father_name',null,['id' => 'father_name','required' => 'required']) !!}

				<label for="father_name">Father Name *</label>

			</div>



			<div class="input-field col s12 l3">

				<i class="mdi-social-person prefix"></i>

				{!! Form::text('mother_name',null,['id' => 'mother_name','required' => 'required']) !!}

				<label for="mother_name">Mother Name *</label>

			</div>



			<div class="input-field col s12 l6">

				<i class="mdi-action-event prefix"></i>

				{!! Form::date('dob',null,['id' => 'dob','class' => 'datepicker']) !!}

				<label for="dob">Date of Birth </label>

			</div>

		</div>



		<div class="row">

			<div class="input-field col s12 l6">

				<i class="mdi-communication-stay-primary-portrait prefix"></i>

				{!! Form::number('phone',null,['id' => 'phone','required' => 'required']) !!}

				<label for="phone">Phone *</label>

			</div>



			<div class="input-field col s12 l6">

				<i class="mdi-communication-phone prefix"></i>

				{!! Form::text('other_contact',null,['id' => 'other_contact']) !!}

				<label for="other_contact">Any Other Contact Number</label>

			</div>

		</div>



		<div class="row">

			<div class="input-field col s12 l6">

				<i class="mdi-communication-email prefix"></i>

				{!! Form::email('email',null,['id' => 'email','required' => 'required']) !!}

				<label for="email">Email *</label>

			</div>



			<div class="input-field col s12 l6">

				{!! Form::select('gender',['M' => 'Male', 'F' => 'Female'],$data->gender,['class' => 'browser-default']) !!}

			</div>

		</div>

	</div>

</div>



<h4 class="header2"> Address</h4>



<div class="col s12 m12 l12">

	<div class="card-panel">

		<div class="row">

			<div class="input-field col s12 l6">

				<i class="mdi-communication-location-on prefix"></i>

				{!! Form::text('state',null,['id' => 'state','required' => 'required']) !!}

				<label for="state">State *</label>

			</div>



			<div class="input-field col s12 l6">

				<i class="mdi-communication-location-on prefix"></i>

				{!! Form::text('city',null,['id' => 'city','required' => 'required']) !!}

				<label for="city">City *</label>

			</div>

		</div>



		<div class="row">

			<div class="input-field col s12">

				<i class="mdi-communication-location-on prefix"></i>

				{!! Form::text('address',null,['id' => 'address','required' => 'required']) !!}

				<label for="address">Address *</label>

			</div>

		</div>

	</div>

</div>



<h4 class="header2"> Upload Documents</h4>



<div class="col s12 m12 l12">

	<div class="card-panel">

		<div class="row">

			@include('branch.users.student.upload_field')

			<span id="upload_field"></span>



			<br>

			<div style="margin-left:20px">

				<button type="button" class="btn cyan" onClick="addUploadField();"><i class="fa fa-plus"></i></button>

			</div>

			<br>

		</div>

	</div>

</div>



<div class="row">

	<div class="input-field col s12">

		<div class="input-field col s12">

			<button class="btn cyan waves-effect waves-light right" type="submit" name="action">Submit <i class="mdi-content-send right"></i></button>

		</div>

	</div>

</div>



@section('js')

<script>

	function addUploadField(){

		$("<div>").load("{{ Asset(env('branch').'/student/addUploadField') }}", function(){

			$("#upload_field").append($(this).html());

		});

	}



	function Remove(id){

		$(id).remove();

	}



	function Prev_Remove(id){

		swal({

        	title: "Are you sure?",

        	text: "Your data will be deleted!",

        	type: "warning",

        	showCancelButton: true,

        	confirmButtonColor: '#DD6B55',

        	confirmButtonText: "Yes, delete it!",

        	closeOnConfirm: false

        }, function(){

        	swal("Deleted!", "Your data has been deleted!", "success");

			window.location.href = "{{ Asset(env('branch').'/student/deleteUploadField') }}/"+id;

        });

	}

</script>

@endsection