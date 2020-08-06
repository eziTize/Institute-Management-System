<div class="row">
	<div class="input-field col s12 l6">
		<i class="mdi-action-home prefix"></i>
		{!! Form::text('name',null,['id' => 'name','required' => 'required','disabled' => 'disabled']) !!}
		<label for="name">Name *</label>
	</div>
	<div class="input-field col s12 l6">
		<i class="mdi-image-timer prefix"></i>
		{!! Form::number('duration',null,['id' => 'duration','required' => 'required','disabled' => 'disabled']) !!}
		<label for="duration">Duration(Month) *</label>
	</div>
</div>

<div class="row">
	<div class="input-field col s12 l6">
		<i class="fa fa-money prefix"></i>
		{!! Form::number('fee',null,['id' => 'fee','required' => 'required','disabled' => 'disabled']) !!}
		<label for="fee">Fee(Rs) *</label>
	</div>
	<div class="input-field col s12 l6">
		{!! Form::select('status',['0' => 'Enable', '1' => 'Disable'],$data->status,['disabled' => 'disabled']) !!}
	</div>
</div>