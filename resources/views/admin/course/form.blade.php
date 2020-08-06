<div class="row">

	<div class="input-field col s12 l6">

		<i class="mdi-action-home prefix"></i>

		{!! Form::text('name',null,['id' => 'name','required' => 'required']) !!}

		<label for="name">Name *</label>

	</div>

	<div class="input-field col s12 l6">

		<i class="mdi-image-timer prefix"></i>

		{!! Form::number('duration',null,['id' => 'duration','required' => 'required']) !!}

		<label for="duration">Duration(Month) *</label>

	</div>

</div>



<div class="row">

	<?php /*<div class="input-field col s12 l6">

		<i class="fa fa-money prefix"></i>

		{!! Form::number('fee',null,['id' => 'fee','required' => 'required']) !!}

		<label for="fee">Fee(Rs) *</label>

	</div>*/ ?>

	<div class="input-field col s12 l12">

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