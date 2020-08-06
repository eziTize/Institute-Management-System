<?php

namespace App\Http\Controllers\Teacher;

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
        $teacher_id = Auth::guard('teacher')->user()->id;
        
        $data = [
            'data' => Task::where('teacher_id', $teacher_id)->get(),
            'task_comment' => new TaskComment,
            'link' => env('teacher').'/task/'
        ];

        return View('teacher.task.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Add Comment for Task
    |------------------------------------------------------------------
    */
    public function addComment(Request $request,$id){
        $data = new TaskComment;

        if($data->validate($request->all())){
            return Redirect(env('teacher').'/task')->withErrors($data->validate($request->all()))->withInput();
        }
        
        $data->task_id = $id;
        $data->comment = $request->get('comment');
        $data->save();

        return Redirect(env('teacher').'/task')->with('message','Comment Made Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Finish Task Request
    |------------------------------------------------------------------
    */
    public function finishTask(Request $request,$id){
        $data = Task::where('id',$id)->where('status','0')->update(['finish_request' => '1']);

        return Redirect(env('teacher').'/task')->with('message','Task Finished Successfully.');
    }
}
