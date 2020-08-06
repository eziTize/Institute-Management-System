<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Branch;
use App\BranchCourse;
use App\Course;
use App\Task;
use App\TaskComment;

class BranchController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Branch List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $data = [
            'data' => Branch::where('is_deleted','0')->get(),
            'task' => new Task,
            'link' => env('admin').'/branch/'
        ];

        return View('admin.users.branch.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Branch Add Page
    |------------------------------------------------------------------
    */
    public function show(){
        $data = [
            'data' => new Branch,
            'link' => env('admin').'/branch/'
        ];

        return View('admin.users.branch.add',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Branch Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request){
        $data = new Branch;

        if($data->validate($request->all(),"add")){
            return Redirect(env('admin').'/branch/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }elseif($data->duplicateChk("add",$request)){
            return Redirect(env('admin').'/branch/add')->with('error','Sorry! '.$data->duplicateChk("add",$request).' Already Exists')->withInput();
        }

        $data->name = $request->get('name');
        $data->email = strtolower($request->get('email'));
        $data->phone = $request->get('phone');
        $data->password = bcrypt($request->get('password'));
        $data->address = $request->get('address');
        $data->status = $request->get('status');
        $data->save();

        return Redirect(env('admin').'/branch')->with('message','New Branch Added Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Edit Branch Page
    |------------------------------------------------------------------
    */
    public function edit($id){
        $data = [
            'id' => $id,
            'data' => Branch::find($id),
            'link' => env('admin').'/branch/'
        ];

        return View('admin.users.branch.edit',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Branch Data Update
    |------------------------------------------------------------------
    */
    public function update(Request $request,$id){
        $data = Branch::find($id);

        if($data->validate($request->all(),"edit")){
            return Redirect(env('admin').'/branch/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }elseif($data->duplicateChk("edit",$request,$id)){
            return Redirect(env('admin').'/branch/'.$id.'/edit')->with('error','Sorry! '.$data->duplicateChk("edit",$request,$id).' Already Exists')->withInput();
        }

        $data->name = $request->get('name');
        $data->email = strtolower($request->get('email'));
        $data->phone = $request->get('phone');
        $data->address = $request->get('address');
        $data->status = $request->get('status');
        
        if($request->get('password')){
            $data->password = bcrypt($request->get('password'));
        }

        $data->save();

        return Redirect(env('admin').'/branch')->with('message','Branch Updated Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Branch Data Delete
    |------------------------------------------------------------------
    */
    public function destroy($id){
        $data = Branch::find($id);
        $data->is_deleted = 1;
        $data->save();

        return Redirect(env('admin').'/branch')->with('message','Branch Deleted Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Branch Trash List Page
    |------------------------------------------------------------------
    */
    public function trash(){
        $data = [
            'data' => Branch::where('is_deleted','1')->get(),
            'link' => env('admin').'/branch/'
        ];

        return View('admin.users.branch.trash',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Branch Data Restore
    |------------------------------------------------------------------
    */
    public function restore($id){
        $data = Branch::find($id);
        $data->is_deleted = 0;
        $data->save();

        return Redirect(env('admin').'/branch/trash')->with('message','Branch Restored Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Branch Data Delete Parmanently
    |------------------------------------------------------------------
    */
    public function destroyPermanent($id){
        $data = Branch::find($id);
        $data->delete();

        return Redirect(env('admin').'/branch/trash')->with('message','Branch Deleted Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Add Course Page for Branch
    |------------------------------------------------------------------
    */
    public function addCourse($id){
        $data = [
            'data' => BranchCourse::where('branch_id',$id)->get(),
            'courses' => Course::where('is_deleted','0')->get(),
            'branch' => Branch::find($id),
            'link' => env('admin').'/branch/'
        ];

        return View('admin.users.branch.add_course',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Course Store for Branch
    |------------------------------------------------------------------
    */
    public function addCourseStore(Request $request,$id){
        $data = new BranchCourse;
        $branch = Branch::find($id);

        if($data->validate($request->all())){
            return Redirect(env('admin').'/branch/'.$id.'/add_course')->withErrors($data->validate($request->all()))->withInput();
        }

        foreach($request->get('course_id') as $course=>$val){
            $fee = $request->get('fee')[$course];
            $status = $request->get('course_id')[$course];
            
            if($fee <= 0 || $status == 'N'){
                $fee = 0;
                $status = 'N';
            }

            $branch_course_arr = [];
            $branch_course_arr['branch_id'] = $id;
            $branch_course_arr['course_id'] = $course;

            $branch_course = BranchCourse::firstOrCreate($branch_course_arr);

            $branch_course->fee = $fee;
            $branch_course->status = $status;
            $branch_course->save();
        }

        return Redirect(env('admin').'/branch/'.$id.'/add_course')->with('message','Course Added on '.$branch->name.' Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Add Task Page for Branch
    |------------------------------------------------------------------
    */
    public function addTask($id){
        $data = [
            'data' => Task::where('branch_id',$id)->where('status','0')->first() ?? new Task,
            'branch' => Branch::find($id),
            'task_comment' => new TaskComment,
            'link' => env('admin').'/branch/'
        ];

        return View('admin.users.branch.add_task',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Task Store for Branch
    |------------------------------------------------------------------
    */
    public function addTaskStore(Request $request,$id){
        $data = Task::where('branch_id',$id)->where('status','0')->first() ?? new Task;
        $branch = Branch::find($id);

        if($data->validate($request->all())){
            return Redirect(env('admin').'/branch/'.$id.'/add_task')->withErrors($data->validate($request->all()))->withInput();
        }

        $data->branch_id = $id;
        $data->task_desc = $request->get('task_desc');
        $data->start_date = $request->get('start_date');
        $data->end_date = $request->get('end_date');
        $data->save();

        return Redirect(env('admin').'/branch/'.$id.'/add_task')->with('message','Task Added on '.$branch->name.' Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Finish Task for Branch
    |------------------------------------------------------------------
    */
    public function finishTask(Request $request,$id){
        $branch = Branch::find($id);
        $data = Task::where('branch_id',$id)->where('status','0')->update(['status' => '1']);

        return Redirect(env('admin').'/branch')->with('message','Task Finished on '.$branch->name.' Successfully.');
    }
}
