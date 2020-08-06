<?php /* As of now Teacher is not managed on branch so added disabled in form */ ?>

<div class="row">
	<div class="input-field col s12 l6">
		<i class="mdi-action-home prefix"></i>
		{!! Form::text('name',null,['id' => 'name','required' => 'required','disabled' => 'disabled']) !!}
		<label for="name">Teacher Name *</label>
	</div>
	<div class="input-field col s12 l6">
		<i class="mdi-communication-email prefix"></i>
		{!! Form::email('email',null,['id' => 'email','class' => 'tolowercase','required' => 'required','disabled' => 'disabled']) !!}
		<label for="email">Email *</label>
	</div>
</div>

<?php /*@isset($id)<small style="color:red">(Enter new password here if you want to change current password.)</small>@endif

<div class="row">
	<div class="input-field col s12 l6">
		<i class="mdi-action-lock prefix"></i>
		{!! Form::password('password',null,['id' => 'password','required' => 'required','disabled' => 'disabled']) !!}
		<label for="password">Password *</label>
	</div>
	<div class="input-field col s12 l6">
		<i class="mdi-action-lock prefix"></i>
		{!! Form::password('confirm_password',null,['id' => 'confirm_password','required' => 'required','disabled' => 'disabled']) !!}
		<label for="confirm_password">Confirm Password *</label>
	</div>
</div> /* As of now Teacher is not managed on branch */ ?>

<div class="row">
	<div class="input-field col s12 l12">
		<i class="mdi-communication-phone prefix"></i>
		{!! Form::number('phone',null,['id' => 'phone','placeholder' => 'Phone number must be of digits','disabled' => 'disabled']) !!}
		<label for="phone">Phone</label>
	</div>
</div>

<div class="row">
	<div class="input-field col s12 l12">
		<i class="mdi-action-home prefix"></i>
		{!! Form::text('address',null,['id' => 'address','disabled' => 'disabled']) !!}
		<label for="address">Address</label>
	</div>
</div>

<div class="row">
	<div class="input-field col s12 l12">
		{!! Form::select('status',['0' => 'Enable', '1' => 'Disable'],$data->status,['disabled' => 'disabled']) !!}
	</div>
</div>

<?php /*<div class="row">
	<div class="input-field col s12">
		<div class="input-field col s12">
			<button class="btn cyan waves-effect waves-light right" type="submit" name="action">Submit <i class="mdi-content-send right"></i></button>
		</div>
	</div>
</div> /* As of now Teacher is not managed on branch */ ?>