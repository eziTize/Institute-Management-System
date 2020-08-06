<div id="makeWalkIn-{{ $enquiry_lead->id }}" class="modal modal-fixed-footer">
	<form action="{{ Asset(env('telecaller').'/enquiry_leads_make_walk_in/'.$enquiry_lead->id) }}" method="post" enctype="multipart/form-data" autocomplete="off">
		<div class="modal-content">
			<h4 class="header2">Make Walk In -  {{ $enquiry_lead->phone }}</h4>
			
			@csrf
			<div class="row">
				<div class="input-field col s12">
					{!! Form::text('student_name',$enquiry_lead->student_name,['id' => 'student_name','required' => 'required']) !!}
					<label for="student_name">Student Name</label>
				</div>
			</div>

			<div class="row">
				<div class="file-field input-field col s12">
			        <div class="btn">
			            <span>Select ID Photo</span>
			            <input type="file" id="id_photo_{{ $enquiry_lead->id }}" name="id_photo" required onchange="checkextension('{{ $enquiry_lead->id }}')">
			        </div>
			        <div class="file-path-wrapper">
			            <input class="file-path validate" type="text" placeholder="Select">
			        </div>
			    </div>
			</div>

			<div class="row">
				<div class="input-field col s12">
					<span id="pic_preview_{{ $enquiry_lead->id }}"></span>
				</div>
			</div>
		</div>

		<div class="modal-footer">
			<a href="javascript:void(0);" class="waves-effect waves-red btn-flat modal-action modal-close">Close</a>
			<button type="submit" class="btn blue modal-action">Submit</button>
		</div>
	</form>
</div>