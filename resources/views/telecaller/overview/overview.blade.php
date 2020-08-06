<div id="card-stats">
	<div class="row">
		@if($task)
		<h4 class="header">
			Current Task: {{ $task->task_desc }}<br>
			Duration: {{ date('d M Y',strtotime($task->start_date)) }} - {{ date('d M Y',strtotime($task->end_date)) }}
		</h4>

		<div class="col s12 m3 l3">
			<div class="card">
				<div class="card-content grey lighten-1 white-text">
					<p class="card-stats-title"><i class="mdi-social-person-add"></i> Total Assigned</p>
					<h4 class="card-stats-number">{{ $assign_count }}</h4>
					<p class="card-stats-compare" style="font-size:12px"><span class="green-text text-lighten-5">For current Task</span></p>
				</div>
				<div class="card-action grey darken-2"></div>
			</div>
		</div>

		<div class="col s12 m3 l3">
			<div class="card">
				<div class="card-content orange lighten-1 white-text">
					<p class="card-stats-title"><i class="mdi-communication-phone"></i> Total Calls</p>
					<h4 class="card-stats-number">{{ $call_count }}</h4>
					<p class="card-stats-compare" style="font-size:12px"><span class="green-text text-lighten-5">For current Task</span></p>
				</div>
				<div class="card-action orange darken-2"></div>
			</div>
		</div>

		<div class="col s12 m3 l3">
			<div class="card">
				<div class="card-content green lighten-1 white-text">
					<p class="card-stats-title"><i class="mdi-maps-directions-walk"></i> Total Walk Ins</p>
					<h4 class="card-stats-number">{{ $walk_in_count }}</h4>
					<p class="card-stats-compare" style="font-size:12px"><span class="green-text text-lighten-5">For current Task</span></p>
				</div>
				<div class="card-action green darken-2"></div>
			</div>
		</div>

		<div class="col s12 m3 l3">
			<div class="card">
				<div class="card-content blue lighten-1 white-text">
					<p class="card-stats-title"><i class="mdi-social-school"></i> Total Admissions</p>
					<h4 class="card-stats-number">{{ $admission_count }}</h4>
					<p class="card-stats-compare" style="font-size:12px"><span class="green-text text-lighten-5">For current Task</span></p>
				</div>
				<div class="card-action blue darken-2"></div>
			</div>
		</div>
		@else
		<h4 class="header">Currently No Task Available</h4>
		@endif
	</div>
</div>