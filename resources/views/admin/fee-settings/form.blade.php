<div class="row">

	<div class="input-field col s12 l6">

		<i class="mdi-action-home prefix"></i>

		{!! Form::text('fee_type',null,['id' => 'fee_type','required' => 'required']) !!}

		<label for="fee_type">Fee Type *</label>

	</div>

	<div class="input-field col s12 l6">

		<i class="fa fa-money prefix"></i>

		{!! Form::number('fee_amount',null,['id' => 'fee_amount','required' => 'required']) !!}

		<label for="fee_amount">Fee Amount (Rs) *</label>

	</div>

</div>



<div class="row">

	<div class="input-field col s12">

		<div class="input-field col s12">

			<button class="btn cyan waves-effect waves-light right" type="submit" name="action">Submit <i class="mdi-content-send right"></i></button>

		</div>

	</div>

</div>