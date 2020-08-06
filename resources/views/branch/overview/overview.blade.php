<div id="card-stats">
	<div class="row">
		@if($task)
		<h4 class="header">
			Current Task: {{ $task->task_desc }}<br>
			Duration: {{ date('d M Y',strtotime($task->start_date)) }} - {{ date('d M Y',strtotime($task->end_date)) }}
		</h4>
		@else
		<h4 class="header">Currently No Task Available</h4>
		@endif
	</div>
</div>