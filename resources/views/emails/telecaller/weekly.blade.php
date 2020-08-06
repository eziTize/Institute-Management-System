@component('mail::message')
Hello,<br>
{{ $data['tel']->name }}

# Your Task Details

**Current Task:** {{ $data['task']->task_desc }}<br>
**Duration:** {{ date('d M Y',strtotime($data['task']->start_date)) }} - {{ date('d M Y',strtotime($data['task']->end_date)) }}

# Assigned: {{ $data['assign_count'] }}
# Called: {{ $data['call_count'] }}
# Walked In: {{ $data['walk_in_count'] }}
# Admitted: {{ $data['admission_count'] }}

@if($data['days_left'] > 0)
# *** {{ ($data['days_left'] > 1) ? $data['days_left'].' days' : $data['days_left'].' day' }} left to complete your task.
@else
# *** Date already over, Please try to give your feedback related to task asap.
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent