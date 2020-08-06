<div id="assign-{{ $enquiry_lead->id }}" class="modal modal-fixed-footer">
	<form action="{{ Asset($link.'assign/'.$enquiry_lead->id) }}" method="post" enctype="multipart/form-data">
		<div class="modal-content">
			<h4 class="header2">Assign Leads -  {{ $enquiry_lead->phone }}</h4>

			@csrf
			<div class="row">
				<div class="input-field col s12 l12">
					<select class="browser-default" id="assigned_to" name="assigned_to" required>
						@foreach($telecaller as $tel)
						<option value="{{ $tel->id }}" @if($enquiry_lead->assigned_to == $tel->id) selected @endif>
							{{ $tel->name }} - {{ $tel->email }}
						</option>
						@endforeach
					</select>
					<label for="assigned_to" class="active">Assigned To</label>
				</div>
			</div>
		</div>

		<div class="modal-footer">
			<a href="javascript:void(0);" class="waves-effect waves-red btn-flat modal-action modal-close">Close</a>
			<button type="submit" class="btn blue modal-action">Assign</button>
		</div>
	</form>
</div>