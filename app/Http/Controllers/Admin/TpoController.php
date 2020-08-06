<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tpo;
use App\Branch;
use App\Task;
use App\TaskComment;

class TpoController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Tpo List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $data = [
            'data' => Tpo::where('is_deleted','0')->get(),
            //'branch' => new Branch, /* As of now Tpo is not dependent on branch */
            'task' => new Task,
            'link' => env('admin').'/tpo/'
        ];

        return View('admin.users.tpo.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Tpo Add Page
    |------------------------------------------------------------------
    */
    public function show(){
        $data = [
            'data' => new Tpo,
            //'branch' => Branch::where('is_deleted','0')->pluck('name','id'), /* As of now Tpo is not dependent on branch */
            'link' => env('admin').'/tpo/'
        ];

        return View('admin.users.tpo.add',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Tpo Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request){
        $data = new Tpo;

        if($data->validate($request->all(),"add")){
            return Redirect(env('admin').'/tpo/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }elseif($data->duplicateChk("add",$request)){
            return Redirect(env('admin').'/tpo/add')->with('error','Sorry! '.$data->duplicateChk("add",$request).' Already Exists')->withInput();
        }

        //$data->branch_id = $request->get('branch_id'); /* As of now Tpo is not dependent on branch */
        $data->name = $request->get('name');
        $data->email = strtolower($request->get('email'));
        $data->phone = $request->get('phone');
        $data->password = bcrypt($request->get('password'));
        $data->address = $request->get('address');
        $data->status = $request->get('status');
        $data->save();

        return Redirect(env('admin').'/tpo')->with('message','New Tpo / Company HR Added Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Edit Tpo Page
    |------------------------------------------------------------------
    */
    public function edit($id){
        $data = [
            'id' => $id,
            'data' => Tpo::find($id),
            //'branch' => Branch::pluck('name','id'), /* As of now Tpo is not dependent on branch */
            'link' => env('admin').'/tpo/'
        ];

        return View('admin.users.tpo.edit',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Tpo Data Update
    |------------------------------------------------------------------
    */
    public function update(Request $request,$id){
        $data = Tpo::find($id);

        if($data->validate($request->all(),"edit")){
            return Redirect(env('admin').'/tpo/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }elseif($data->duplicateChk("edit",$request,$id)){
            return Redirect(env('admin').'/tpo/'.$id.'/edit')->with('error','Sorry! '.$data->duplicateChk("edit",$request,$id).' Already Exists')->withInput();
        }

        //$data->branch_id = $request->get('branch_id'); /* As of now Tpo is not dependent on branch */
        $data->name = $request->get('name');
        $data->email = strtolower($request->get('email'));
        $data->phone = $request->get('phone');
        $data->address = $request->get('address');
        $data->status = $request->get('status');
        
        if($request->get('password')){
            $data->password = bcrypt($request->get('password'));
        }

        $data->save();

        return Redirect(env('admin').'/tpo')->with('message','Tpo / Company HR Updated Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Tpo Data Delete
    |------------------------------------------------------------------
    */
    public function destroy($id){
        $data = Tpo::find($id);
        $data->is_deleted = 1;
        $data->save();

        return Redirect(env('admin').'/tpo')->with('message','Tpo / Company HR Deleted Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Tpo Trash List Page
    |------------------------------------------------------------------
    */
    public function trash(){
        $data = [
            'data' => Tpo::where('is_deleted','1')->get(),
            //'branch' => new Branch, /* As of now Tpo is not dependent on branch */
            'task' => new Task,
            'link' => env('admin').'/tpo/'
        ];

        return View('admin.users.tpo.trash',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Tpo Data Restore
    |------------------------------------------------------------------
    */
    public function restore($id){
        $data = Tpo::find($id);
        $data->is_deleted = 0;
        $data->save();

        return Redirect(env('admin').'/tpo/trash')->with('message','Tpo / Company HR Restored Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Tpo Data Delete Parmanently
    |------------------------------------------------------------------
    */
    public function destroyPermanent($id){
        $data = Tpo::find($id);
        $data->delete();

        return Redirect(env('admin').'/tpo/trash')->with('message','Tpo / Company HR Deleted Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Add Task Page for Tpo
    |------------------------------------------------------------------
    */
    public function addTask($id){
        $data = [
            'data' => Task::where('tpo_id',$id)->where('status','0')->first() ?? new Task,
            'tpo' => Tpo::find($id),
            'task_comment' => new TaskComment,
            'link' => env('admin').'/tpo/'
        ];

        return View('admin.users.tpo.add_task',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Task Store for Tpo
    |------------------------------------------------------------------
    */
    public function addTaskStore(Request $request,$id){
        $data = Task::where('tpo_id',$id)->where('status','0')->first() ?? new Task;
        $tpo = Tpo::find($id);

        if($data->validate($request->all())){
            return Redirect(env('admin').'/tpo/'.$id.'/add_task')->withErrors($data->validate($request->all()))->withInput();
        }

        $data->tpo_id = $id;
        $data->task_desc = $request->get('task_desc');
        $data->start_date = $request->get('start_date');
        $data->end_date = $request->get('end_date');
        $data->save();

        return Redirect(env('admin').'/tpo/'.$id.'/add_task')->with('message','Task Added on '.$tpo->name.' Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Finish Task for Tpo
    |------------------------------------------------------------------
    */
    public function finishTask(Request $request,$id){
        $tpo = Tpo::find($id);
        $data = Task::where('tpo_id',$id)->where('status','0')->update(['status' => '1']);

        return Redirect(env('admin').'/tpo')->with('message','Task Finished on '.$tpo->name.' Successfully.');
    }
}
