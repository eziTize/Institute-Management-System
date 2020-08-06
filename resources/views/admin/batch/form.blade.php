<div class="row">

	<div class="input-field col s12 l12">

		<select class="browser-default" name="branch_course" required>

			@if($data->id)

			<option value="{{ $data->branch_course_id }}">

				{{ $data->course_name }} - Fee: {{ $data->fee }} ({{ $data->branch_name }})

			</option>

			@else

			<option value="">Select Course</option>

			@foreach($branch_course as $brn_crs)

			<option value="{{ $brn_crs->id }}">

				{{ $course->find($brn_crs->course_id)->name }} - Fee: {{ $brn_crs->fee }} ({{ $branch->find($brn_crs->branch_id)->name }})

			</option>

			@endforeach

			@endif

		</select>

	</div>

</div>

<div class="row">

	<div class="input-field col s12 l6">

		<i class="mdi-action-home prefix"></i>

		{!! Form::text('name',null,['id' => 'name','required' => 'required']) !!}

		<label for="name">Name *</label>

	</div>

	<div class="input-field col s12 l6">

		{!! Form::select('status',['0' => 'Enable', '1' => 'Disable'],$data->status) !!}

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

    window.onload = function(){

        @if(!$data->id)

		$('[name="branch_course"]').val("{{ Old('branch_course') ?? '' }}")

		@endif

    };

</script>

@endsection