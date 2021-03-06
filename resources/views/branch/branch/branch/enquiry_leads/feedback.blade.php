<div id="feedback-{{ $enquiry_lead->id }}" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4 class="header2">Details of Leads -  {{ $enquiry_lead->phone }}</h4>

		<div class="row">
			<div class="input-field col s12 l4">
				@if($enquiry_lead->id_photo)
				<img src="{{ Asset('/upload/walkin/'.$enquiry_lead->id_photo) }}" style="height:100px;">
				@else
				<h5>No Photo Uploaded</h5>
				@endif
			</div>

			<div class="input-field col s12 l8">
				<div class="input-field col s12 l12">
					<select class="browser-default" id="lead_quality" name="lead_quality" required disabled>
						@foreach($lead_quality as $lead_qlty)
						<option value="{{ $lead_qlty->id }}" @if($enquiry_lead->lead_quality == $lead_qlty->id) selected @endif>{{ $lead_qlty->name }}</option>
						@endforeach
					</select>
					<label for="lead_quality" class="active">Lead Quality</label>
				</div>

				<div class="input-field col s12 l12">
					{!! Form::text('student_name',$enquiry_lead->student_name,['id' => 'student_name','disabled' => 'disabled']) !!}
					<label for="student_name">Student Name</label>
				</div>
			</div>
		</div><hr>

		<h4 class="header2">Feedbacks</h4>

		<div class="row">
			<div class="input-field col s12 l12">
				<?php $comments = $enquiry_lead->getAllComments($enquiry_lead->id); ?>
				@foreach($comments as $comment)
				<span>
					{{ $comment->comments }}
					<br>
					<small>{{ date('d-M-Y h:i:s a',strtotime($comment->created_at)) }}</small>
					<br><br>
				</span>
				@endforeach
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<a href="javascript:void(0);" class="waves-effect waves-red btn-flat modal-action modal-close">Close</a>
	</div>
</div>