<div class="row">
	<div class="input-field col s12 l6">
		<i class="mdi-action-home prefix"></i>
		{!! Form::text('name',$data->name,['id' => 'name','required' => 'required']) !!}
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