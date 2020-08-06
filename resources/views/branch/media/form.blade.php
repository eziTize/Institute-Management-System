<div class="row">
	<div class="input-field col s12 l5">
		{!! Form::text('media_name',null,['id' => 'media_name','required' => 'required']) !!}
		<label for="media_name">Media Name</label>
	</div>

	<div class="file-field input-field col s12 l6">
		<div class="btn">
			<span>Select Document</span>
			<input type="file" name="media_file" required>
		</div>

		<div class="file-path-wrapper">
			<input class="file-path validate" type="text" placeholder="Select" value="{{ $data->media_file }}">
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