<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Teacher;
use App\Branch;
use App\Task;
use App\TaskComment;

class TeacherController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Teacher List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $data = [
            'data' => Teacher::where('is_deleted','0')->get(),
            'branch' => new Branch,
            'task' => new Task,
            'link' => env('admin').'/teacher/'
        ];

        return View('admin.users.teacher.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Teacher Add Page
    |------------------------------------------------------------------
    */
    public function show(){
        $data = [
            'data' => new Teacher,
            'branch' => Branch::where('is_deleted','0')->pluck('name','id'),
            'link' => env('admin').'/teacher/'
        ];

        return View('admin.users.teacher.add',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Teacher Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request){
        $data = new Teacher;

        if($data->validate($request->all(),"add")){
            return Redirect(env('admin').'/teacher/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }elseif($data->duplicateChk("add",$request)){
            return Redirect(env('admin').'/teacher/add')->with('error','Sorry! '.$data->duplicateChk("add",$request).' Already Exists')->withInput();
        }

        $data->branch_id = $request->get('branch_id');
        $data->name = $request->get('name');
        $data->email = strtolower($request->get('email'));
        $data->phone = $request->get('phone');
        $data->password = bcrypt($request->get('password'));
        $data->address = $request->get('address');
        $data->status = $request->get('status');
        $data->save();

        return Redirect(env('admin').'/teacher')->with('message','New Teacher Added Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Edit Teacher Page
    |------------------------------------------------------------------
    */
    public function edit($id){
        $data = [
            'id' => $id,
            'data' => Teacher::find($id),
            'branch' => Branch::pluck('name','id'),
            'link' => env('admin').'/teacher/'
        ];

        return View('admin.users.teacher.edit',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Teacher Data Update
    |------------------------------------------------------------------
    */
    public function update(Request $request,$id){
        $data = Teacher::find($id);

        if($data->validate($request->all(),"edit")){
            return Redirect(env('admin').'/teacher/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }elseif($data->duplicateChk("edit",$request,$id)){
            return Redirect(env('admin').'/teacher/'.$id.'/edit')->with('error','Sorry! '.$data->duplicateChk("edit",$request,$id).' Already Exists')->withInput();
        }

        $data->branch_id = $request->get('branch_id');
        $data->name = $request->get('name');
        $data->email = strtolower($request->get('email'));
        $data->phone = $request->get('phone');
        $data->address = $request->get('address');
        $data->status = $request->get('status');
        
        if($request->get('password')){
            $data->password = bcrypt($request->get('password'));
        }

        $data->save();

        return Redirect(env('admin').'/teacher')->with('message','Teacher Updated Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Teacher Data Delete
    |------------------------------------------------------------------
    */
    public function destroy($id){
        $data = Teacher::find($id);
        $data->is_deleted = 1;
        $data->save();

        return Redirect(env('admin').'/teacher')->with('message','Teacher Deleted Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Teacher Trash List Page
    |------------------------------------------------------------------
    */
    public function trash(){
        $data = [
            'data' => Teacher::where('is_deleted','1')->get(),
            'branch' => new Branch,
            'link' => env('admin').'/teacher/'
        ];

        return View('admin.users.teacher.trash',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Teacher Data Restore
    |------------------------------------------------------------------
    */
    public function restore($id){
        $data = Teacher::find($id);
        $data->is_deleted = 0;
        $data->save();

        return Redirect(env('admin').'/teacher/trash')->with('message','Teacher Restored Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Teacher Data Delete Parmanently
    |------------------------------------------------------------------
    */
    public function destroyPermanent($id){
        $data = Teacher::find($id);
        $data->delete();

        return Redirect(env('admin').'/teacher/trash')->with('message','Teacher Deleted Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Add Task Page for Teacher
    |------------------------------------------------------------------
    */
    public function addTask($id){
        $data = [
            'data' => Task::where('teacher_id',$id)->where('status','0')->first() ?? new Task,
            'teacher' => Teacher::find($id),
            'task_comment' => new TaskComment,
            'link' => env('admin').'/teacher/'
        ];

        return View('admin.users.teacher.add_task',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Task Store for Teacher
    |------------------------------------------------------------------
    */
    public function addTaskStore(Request $request,$id){
        $data = Task::where('teacher_id',$id)->where('status','0')->first() ?? new Task;
        $teacher = Teacher::find($id);

        if($data->validate($request->all())){
            return Redirect(env('admin').'/teacher/'.$id.'/add_task')->withErrors($data->validate($request->all()))->withInput();
        }

        $data->teacher_id = $id;
        $data->task_desc = $request->get('task_desc');
        $data->start_date = $request->get('start_date');
        $data->end_date = $request->get('end_date');
        $data->save();

        return Redirect(env('admin').'/teacher/'.$id.'/add_task')->with('message','Task Added on '.$teacher->name.' Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Finish Task for Teacher
    |------------------------------------------------------------------
    */
    public function finishTask(Request $request,$id){
        $teacher = Teacher::find($id);
        $data = Task::where('teacher_id',$id)->where('status','0')->update(['status' => '1']);

        return Redirect(env('admin').'/teacher')->with('message','Task Finished on '.$teacher->name.' Successfully.');
    }
}
