<div class="row">
	<div class="input-field col s12 l12">
		<i class="mdi-action-subject prefix"></i>
		{!! Form::text('title',null,['id' => 'title']) !!}
		<label for="title">Title</label>
	</div>
</div>

<div class="row">
	<div class="input-field col s12 l12">
		<i class="mdi-image-edit prefix"></i>
		{!! Form::textarea('description',null,['id' => 'description','class' => 'materialize-textarea']) !!}
		<label for="description">Description</label>
	</div>
</div>

<div class="row">
	<div class="input-field col s12">
		<div class="input-field col s12">
			<button class="btn cyan waves-effect waves-light right" type="submit" name="action">Submit <i class="mdi-content-send right"></i></button>
		</div>
	</div>
</div>