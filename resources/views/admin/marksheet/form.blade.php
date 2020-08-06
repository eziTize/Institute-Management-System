<h5 class="header2">Marksheet Details</h5>



<div class="col s12 m12 l12">

	<div class="card-panel">

		<div class="row">

			<div class="input-field col s12">

				<i class="mdi-social-person prefix"></i>


				<select style="padding-left: 40px" class="browser-default" name="student_id" required>


				@if($data->student_id)

				<option value="{{$data->student_id}}"> {{$student->find($data->student_id)->name}} </option>

				@else
					<option value="">Select Student *</option>

				@endif

					@foreach($student as $students)

					@if($students->id != $data->student_id )

					<option value="{{ $students->id }}">

					{{ $students->name }}

					</option>

					@endif

					@endforeach


				</select>

			</div>


			<div class="input-field col s12 l6">

				<i class="fa fa-book prefix"></i>

				<select style="padding-left: 40px" class="browser-default" name="course_name" required>

				@if($data->course_name)

				<option value="{{$data->course_name}}"> {{$data->course_name}} </option>

				@else

					<option value="">Select Course *</option>

				@endif

					@foreach($course as $courses)

					@if($courses->name != $data->course_name )

					<option value="{{ $courses->name }}">

					{{ $courses->name }}

					</option>

					@endif

					@endforeach


				</select>

			</div>


			<div class="input-field col s12 l6">

				<i class="fa fa-group prefix"></i>

				<select style="padding-left: 40px" class="browser-default" name="batch_id" required>

				@if($data->batch_id)

				<option value="{{$data->batch_id}}"> {{$batch->find($data->batch_id)->name}} </option>

				@else
					<option value="">Select Batch *</option>

				@endif

					@foreach($batch as $bch)

					@if($bch->id != $data->batch_id )

					<option value="{{ $bch->id }}">

					{{ $bch->name }}

					</option>

					@endif

					@endforeach


				</select>

			</div>


		</div>



		<div class="row">

			<div class="input-field col s12 l6">

				<i class="fa fa-mortar-board prefix"></i>

				{!! Form::text('semester',null,['id' => 'semester','required' => 'required']) !!}

				<label for="semester">Semester *</label>

			</div>


			<div class="input-field col s12 l6">

				<i class="fa fa-bookmark prefix"></i>

				{!! Form::text('session',null,['id' => 'session','required' => 'required']) !!}

				<label for="session">Session *</label>

			</div>

			
		</div>


		<div class="row">

			<div class="input-field col s12 l6">

				<i class="fa fa-cubes prefix"></i>

				{!! Form::text('roll_no',null,['id' => 'roll_no','required' => 'required']) !!}

				<label for="roll_no">Roll No *</label>

			</div>


			<div class="input-field col s12 l6">

				<i class="fa fa-copy prefix"></i>

				{!! Form::text('msheet_no',null,['id' => 'msheet_no','required' => 'required']) !!}

				<label for="msheet_no">Marksheet No *</label>

			</div>

			
		</div>

	</div>

</div>



<h5 class="header2"> Written Examination </h5>



<div class="col s12 m12 l12">

	<div class="card-panel">


		<h4 class="header2"> Mock Test </h4>


		<div class="row">

			<div class="input-field col s12 l6">

				<i class="fa fa-th-large prefix"></i>

				{!! Form::text('mtwe_fm',100,['id' => 'mtwe_fm','required' => 'required']) !!}

				<label for="mtwe_fm">Full Marks *</label>

			</div>


			<div class="input-field col s12 l6">

				<i class="fa fa-th-large prefix"></i>

				{!! Form::text('mtwe_om',null,['id' => 'mtwe_om','required' => 'required']) !!}

				<label for="mtwe_om">Marks Obtained *</label>

			</div>

			
		</div>


		<h4 class="header2"> Time Sketch </h4>


		<div class="row">

			<div class="input-field col s12 l6">

				<i class="fa fa-th-large prefix"></i>

				{!! Form::text('tswe_fm',100,['id' => 'tswe_fm','required' => 'required']) !!}

				<label for="tswe_fm">Full Marks *</label>

			</div>


			<div class="input-field col s12 l6">

				<i class="fa fa-th-large prefix"></i>

				{!! Form::text('tswe_om',null,['id' => 'tswe_om','required' => 'required']) !!}

				<label for="tswe_om">Marks Obtained *</label>

			</div>

			
		</div>

	</div>

</div>



<h5 class="header2"> Sessional Part</h5>



<div class="col s12 m12 l12">

	<div class="card-panel">

		<div class="row">

			<div class="input-field col s12 l6">

				<i class="fa fa-th-large prefix"></i>

				{!! Form::text('sp_fm',3400,['id' => 'sp_fm','required' => 'required']) !!}

				<label for="sp_fm">Full Marks *</label>

			</div>


			<div class="input-field col s12 l6">

				<i class="fa fa-th-large prefix"></i>

				{!! Form::text('sp_om',null,['id' => 'sp_om','required' => 'required']) !!}

				<label for="sp_om">Marks Obtained *</label>

			</div>

			
		</div>

	</div>

</div>



<h5 class="header2"> Viva </h5>



<div class="col s12 m12 l12">

	<div class="card-panel">

		<div class="row">

			<div class="input-field col s12 l6">

				<i class="fa fa-th-large prefix"></i>

				{!! Form::text('viva_fm',300,['id' => 'viva_fm']) !!}

				<label for="viva_fm">Full Marks </label>

			</div>


			<div class="input-field col s12 l6">

				<i class="fa fa-th-large prefix"></i>

				{!! Form::text('viva_om',null,['id' => 'viva_om']) !!}

				<label for="viva_om">Marks Obtained </label>

			</div>

			
		</div>

	</div>

</div>

<h5 class="header2"> Field Training </h5>



<div class="col s12 m12 l12">

	<div class="card-panel">

		<div class="row">

			<div class="input-field col s12 l6">

				<i class="fa fa-th-large prefix"></i>

				{!! Form::text('ft_fm',100,['id' => 'ft_fm']) !!}

				<label for="ft_fm">Full Marks </label>

			</div>


			<div class="input-field col s12 l6">

				<i class="fa fa-th-large prefix"></i>

				{!! Form::text('ft_om',null,['id' => 'ft_om']) !!}

				<label for="ft_om">Marks Obtained </label>

			</div>

			
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