<?php

namespace App\Http\Controllers\Telecaller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Task;
use App\TaskComment;

class TaskController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Task List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $telecaller_id = Auth::guard('telecaller')->user()->id;
        
        $data = [
            'data' => Task::where('telecaller_id', $telecaller_id)->get(),
            'task_comment' => new TaskComment,
            'link' => env('telecaller').'/task/'
        ];

        return View('telecaller.task.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Add Comment for Task
    |------------------------------------------------------------------
    */
    public function addComment(Request $request,$id){
        $data = new TaskComment;

        if($data->validate($request->all())){
            return Redirect(env('telecaller').'/task')->withErrors($data->validate($request->all()))->withInput();
        }
        
        $data->task_id = $id;
        $data->comment = $request->get('comment');
        $data->save();

        return Redirect(env('telecaller').'/task')->with('message','Comment Made Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Finish Task Request
    |------------------------------------------------------------------
    */
    public function finishTask(Request $request,$id){
        $data = Task::where('id',$id)->where('status','0')->update(['finish_request' => '1']);

        return Redirect(env('telecaller').'/task')->with('message','Task Finished Successfully.');
    }
}
