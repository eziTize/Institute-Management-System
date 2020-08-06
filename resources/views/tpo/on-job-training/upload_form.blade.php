


<div class="col s12 m12 l12">

	<div class="card-panel">

		<div class="row">

			@include('tpo.on-job-training.upload_field')

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

		$("<div>").load("{{ Asset(env('tpo').'/on-job-training/addUploadField') }}", function(){

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

			window.location.href = "{{ Asset(env('tpo').'/on-job-training/deleteUploadField') }}/"+id;

        });

	}

	

</script>

@endsection