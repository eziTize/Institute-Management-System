<?php

namespace App\Http\Controllers\MarketingPerson;

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
        $marketing_person_id = Auth::guard('marketing_person')->user()->id;
        
        $data = [
            'data' => Task::where('marketing_person_id', $marketing_person_id)->get(),
            'task_comment' => new TaskComment,
            'link' => env('marketing_person').'/task/'
        ];

        return View('marketing_person.task.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Add Comment for Task
    |------------------------------------------------------------------
    */
    public function addComment(Request $request,$id){
        $data = new TaskComment;

        if($data->validate($request->all())){
            return Redirect(env('marketing_person').'/task')->withErrors($data->validate($request->all()))->withInput();
        }
        
        $data->task_id = $id;
        $data->comment = $request->get('comment');
        $data->save();

        return Redirect(env('marketing_person').'/task')->with('message','Comment Made Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Finish Task Request
    |------------------------------------------------------------------
    */
    public function finishTask(Request $request,$id){
        $data = Task::where('id',$id)->where('status','0')->update(['finish_request' => '1']);

        return Redirect(env('marketing_person').'/task')->with('message','Task Finished Successfully.');
    }
}
