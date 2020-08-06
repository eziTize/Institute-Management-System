<div class="row">

	<div class="input-field col s12 112">


		<select class="browser-default" name="student_id" required>

			<option value="">Select Student *</option>

			@foreach($student as $students)

			<option value="{{ $students->id }}">

			{{ $students->name }}

			</option>

			@endforeach


		</select>

	</div>

</div>

<br>

<div class="row">

	<div class="input-field col s12 l6">

		<i class="fa fa-money prefix"></i>

		{!! Form::number('fee', null,['id' => 'fee','required' => 'required']) !!}

		<label for="fee"> Fee Paid (Rs) *</label>

	</div>


	<div class="input-field col s12 l6">

		<i class="fa fa-info prefix"></i>

		{!! Form::text('description',null,['id' => 'description', 'required' => 'required']) !!}

		<label for="description">Fee Description (eg: Exam Fee) *</label>

	</div>

	<div class="input-field col s12 112">

		<i class="fa fa-calendar prefix"></i>

		{!! Form::date('fee_date',null,['id' => 'fee_date','required' => 'required', 'class' => 'datepicker' ]) !!}

        <label for="fee_date">Date *</label>


	</div>

	
</div>


<div class="row">

	

	<div class="input-field col s12">

		<div class="input-field col s12">

			<button class="btn cyan waves-effect waves-light right" type="submit" name="action">Submit <i class="mdi-content-send right"></i></button>

		</div>

	</div>

</div>





