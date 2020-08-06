<div id="excelUpload" class="modal modal-fixed-footer">
	<form action="{{ Asset($link.'bulk_upload') }}" method="post" enctype="multipart/form-data">
		<div class="modal-content">
			<p>Fill all data in same format that is in demo file. For more detail check the following instruction.</p>

			<a href="{{ Asset($link.'excel_format_download') }}" target="_blank" class="btn blue modal-action modal-close">Download Demo File</a><br><br>

			<div class="row">
				<div class="col s4"><b>Phone Number</b></div>
				<div class="col s8">Enter Digits Only</div>
			</div><hr>
			<div class="row">
				<div class="col s4"><b>Enquiry Source</b></div>
				<div class="col s8">Select From Dropdown List</div>
			</div><hr>
			<div class="row">
				<div class="col s12">Maximum upto 1000 data can be uploaded at a time</div>
			</div>

			@csrf
			<div class="row">
				<div class="file-field input-field col s12">
					<div class="btn">
						<span>Select File</span>
						<input class="bulk_xlsx" type="file" name="bulk_file" required accept=".xlsx">
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text" placeholder="File formate should be in excelsheet(.xlsx).">
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="javascript:void(0);" class="waves-effect waves-red btn-flat modal-action modal-close">Close</a>
			<button type="submit" class="btn blue modal-action">Upload</button>
		</div>
	</form>
</div>