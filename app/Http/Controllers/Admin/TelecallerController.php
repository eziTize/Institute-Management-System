<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Telecaller;
use App\Branch;
use App\Task;
use App\TaskComment;

class TelecallerController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Telecaller List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $data = [
            'data' => Telecaller::where('is_deleted','0')->get(),
            //'branch' => new Branch, /* As of now Telecaller is not dependent on branch */
            'task' => new Task,
            'link' => env('admin').'/telecaller/'
        ];

        return View('admin.users.telecaller.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Telecaller Add Page
    |------------------------------------------------------------------
    */
    public function show(){
        $data = [
            'data' => new Telecaller,
            //'branch' => Branch::where('is_deleted','0')->pluck('name','id'), /* As of now Telecaller is not dependent on branch */
            'link' => env('admin').'/telecaller/'
        ];

        return View('admin.users.telecaller.add',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Telecaller Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request){
        $data = new Telecaller;

        if($data->validate($request->all(),"add")){
            return Redirect(env('admin').'/telecaller/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }elseif($data->duplicateChk("add",$request)){
            return Redirect(env('admin').'/telecaller/add')->with('error','Sorry! '.$data->duplicateChk("add",$request).' Already Exists')->withInput();
        }

        //$data->branch_id = $request->get('branch_id'); /* As of now Telecaller is not dependent on branch */
        $data->name = $request->get('name');
        $data->email = strtolower($request->get('email'));
        $data->phone = $request->get('phone');
        $data->password = bcrypt($request->get('password'));
        $data->address = $request->get('address');
        $data->status = $request->get('status');
        $data->save();

        return Redirect(env('admin').'/telecaller')->with('message','New Telecaller / Counsellor Added Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Edit Telecaller Page
    |------------------------------------------------------------------
    */
    public function edit($id){
        $data = [
            'id' => $id,
            'data' => Telecaller::find($id),
            //'branch' => Branch::pluck('name','id'), /* As of now Telecaller is not dependent on branch */
            'link' => env('admin').'/telecaller/'
        ];

        return View('admin.users.telecaller.edit',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Telecaller Data Update
    |------------------------------------------------------------------
    */
    public function update(Request $request,$id){
        $data = Telecaller::find($id);

        if($data->validate($request->all(),"edit")){
            return Redirect(env('admin').'/telecaller/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }elseif($data->duplicateChk("edit",$request,$id)){
            return Redirect(env('admin').'/telecaller/'.$id.'/edit')->with('error','Sorry! '.$data->duplicateChk("edit",$request,$id).' Already Exists')->withInput();
        }

        //$data->branch_id = $request->get('branch_id'); /* As of now Telecaller is not dependent on branch */
        $data->name = $request->get('name');
        $data->email = strtolower($request->get('email'));
        $data->phone = $request->get('phone');
        $data->address = $request->get('address');
        $data->status = $request->get('status');
        
        if($request->get('password')){
            $data->password = bcrypt($request->get('password'));
        }

        $data->save();

        return Redirect(env('admin').'/telecaller')->with('message','Telecaller / Counsellor Updated Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Telecaller Data Delete
    |------------------------------------------------------------------
    */
    public function destroy($id){
        $data = Telecaller::find($id);
        $data->is_deleted = 1;
        $data->save();

        return Redirect(env('admin').'/telecaller')->with('message','Telecaller / Counsellor Deleted Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Telecaller Trash List Page
    |------------------------------------------------------------------
    */
    public function trash(){
        $data = [
            'data' => Telecaller::where('is_deleted','1')->get(),
            //'branch' => new Branch, /* As of now Telecaller is not dependent on branch */
            'link' => env('admin').'/telecaller/'
        ];

        return View('admin.users.telecaller.trash',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Telecaller Data Restore
    |------------------------------------------------------------------
    */
    public function restore($id){
        $data = Telecaller::find($id);
        $data->is_deleted = 0;
        $data->save();

        return Redirect(env('admin').'/telecaller/trash')->with('message','Telecaller / Counsellor Restored Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Telecaller Data Delete Parmanently
    |------------------------------------------------------------------
    */
    public function destroyPermanent($id){
        $data = Telecaller::find($id);
        $data->delete();

        return Redirect(env('admin').'/telecaller/trash')->with('message','Telecaller / Counsellor Deleted Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Add Task Page for Telecaller
    |------------------------------------------------------------------
    */
    public function addTask($id){
        $data = [
            'data' => Task::where('telecaller_id',$id)->where('status','0')->first() ?? new Task,
            'telecaller' => Telecaller::find($id),
            'task_comment' => new TaskComment,
            'link' => env('admin').'/telecaller/'
        ];

        return View('admin.users.telecaller.add_task',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Task Store for Telecaller
    |------------------------------------------------------------------
    */
    public function addTaskStore(Request $request,$id){
        $data = Task::where('telecaller_id',$id)->where('status','0')->first() ?? new Task;
        $telecaller = Telecaller::find($id);

        if($data->validate($request->all())){
            return Redirect(env('admin').'/telecaller/'.$id.'/add_task')->withErrors($data->validate($request->all()))->withInput();
        }

        $data->telecaller_id = $id;
        $data->task_desc = $request->get('task_desc');
        $data->start_date = $request->get('start_date');
        $data->end_date = $request->get('end_date');
        $data->save();

        return Redirect(env('admin').'/telecaller/'.$id.'/add_task')->with('message','Task Added on '.$telecaller->name.' Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Finish Task for Telecaller
    |------------------------------------------------------------------
    */
    public function finishTask(Request $request,$id){
        $telecaller = Telecaller::find($id);
        $data = Task::where('telecaller_id',$id)->where('status','0')->update(['status' => '1']);

        return Redirect(env('admin').'/telecaller')->with('message','Task Finished on '.$telecaller->name.' Successfully.');
    }
}
