<?php
namespace App\Http\Controllers\Cron;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendTelecallerWeeklyMail;
use App\Telecaller;
use App\Task;
use App\EnquiryLeads;

class CronController extends Controller {
	
	public function run(){
		$telecaller = Telecaller::where('status','0')->where('is_deleted','0')->get();

		foreach($telecaller as $tel){
			$task = Task::where('telecaller_id', $tel->id)->where('finish_request','0')->first();

			if($task){
	            $from = $task->start_date;
	            $to = $task->end_date;
	            $now = strtotime('now');

	            $assign_count = EnquiryLeads::where('assigned_to', $tel->id)->whereBetween('assigned_date',[$from,$to])->where('status','>','0')->count();
	            $call_count = EnquiryLeads::where('assigned_to', $tel->id)->whereBetween('assigned_date',[$from,$to])->where('status','>','1')->count();
	            $walk_in_count = EnquiryLeads::where('assigned_to', $tel->id)->whereBetween('assigned_date',[$from,$to])->where('status','>','2')->count();
	            $admission_count = EnquiryLeads::where('assigned_to', $tel->id)->whereBetween('assigned_date',[$from,$to])->where('status','>','3')->count();

	            $days_left = round((strtotime($to) - $now)/86400);

	            $data = [
	            	'tel' => $tel,
	            	'task' => $task,
		            'assign_count' => $assign_count,
		            'call_count' => $call_count,
		            'walk_in_count' => $walk_in_count,
		            'admission_count' => $admission_count,
		            'days_left' => $days_left
				];

		        Mail::to($tel->email)->send(new SendTelecallerWeeklyMail($data));
	        }
		}
	}
}
