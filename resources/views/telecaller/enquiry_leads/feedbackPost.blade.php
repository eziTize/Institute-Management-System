<div id="feedbackPost-{{ $enquiry_lead->id }}" class="modal modal-fixed-footer">
	<form action="{{ Asset(env('telecaller').'/enquiry_leads_feedback/'.$enquiry_lead->id) }}" method="post" autocomplete="off">
		<div class="modal-content">
			<h4 class="header2">Make Comments -  {{ $enquiry_lead->phone }}</h4>
			
			@csrf
			<input type="hidden" name="type" value="{{ $type }}">
			<div class="row">
				<div class="input-field col s12 l6">
					{!! Form::text('student_name',$enquiry_lead->student_name,['id' => 'student_name']) !!}
					<label for="student_name">Student Name</label>
				</div>

				<div class="input-field col s12 l6">
					<select class="browser-default" id="course" name="course" required>
						@foreach($course as $crs)
						<option value="{{ $crs->id }}" @if($enquiry_lead->course == $crs->id) selected @endif>{{ $crs->name }}</option>
						@endforeach
					</select>
					<label for="course" class="active">Course</label>
				</div>
			</div>

			<div class="row">
				<div class="input-field col s12 l12">
					<select class="browser-default" id="lead_quality" name="lead_quality" required>
						@foreach($lead_quality as $lead_qlty)
						<option value="{{ $lead_qlty->id }}" @if($enquiry_lead->lead_quality == $lead_qlty->id) selected @endif>{{ $lead_qlty->name }}</option>
						@endforeach
					</select>
					<label for="lead_quality" class="active">Lead Quality</label>
				</div>
			</div>

			<div class="row">
				<div class="input-field col s12 l12">
					{!! Form::text('comments',null,['id' => 'comments','required' => 'required']) !!}
					<label for="comments">Comment</label>
				</div>
			</div>

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
			<button type="submit" class="btn blue modal-action">Submit</button>
		</div>
	</form>
</div>