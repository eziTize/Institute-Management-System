<div class="row">
	<div class="input-field col s12 l6">
		<i class="mdi-action-home prefix"></i>
		{!! Form::text('student_name',null,['id' => 'student_name']) !!}
		<label for="student_name">Student Name *</label>
	</div>

	<div class="input-field col s12 l6">
		<i class="mdi-action-home prefix"></i>
		{!! Form::number('phone',null,['id' => 'phone','required' => 'required']) !!}
		<label for="phone">Phone Number *</label>
	</div>
</div>

<div class="row">
	<div class="input-field col s12 l6">
		{!! Form::select('enquiry_src',$enquiry_src,$data->enquiry_src) !!}
		<label for="enquiry_src">Enquiry Source *</label>
	</div>

	<div class="input-field col s12 l6">
		{!! Form::select('course',$course,$data->course) !!}
		<label for="course">Course *</label>
	</div>
</div>

<div class="row">
	<div class="input-field col s12">
		<div class="input-field col s12">
			<button class="btn cyan waves-effect waves-light right" type="submit" name="action">Submit <i class="mdi-content-send right"></i></button>
		</div>
	</div>
</div>