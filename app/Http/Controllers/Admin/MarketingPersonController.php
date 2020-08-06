<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MarketingPerson;
use App\Branch;
use App\Task;
use App\TaskComment;

class MarketingPersonController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Marketing Person List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $data = [
            'data' => MarketingPerson::where('is_deleted','0')->get(),
            //'branch' => new Branch, /* As of now Marketing Person is not dependent on branch */
            'task' => new Task,
            'link' => env('admin').'/marketing_person/'
        ];

        return View('admin.users.marketing_person.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Marketing Person Add Page
    |------------------------------------------------------------------
    */
    public function show(){
        $data = [
            'data' => new MarketingPerson,
            //'branch' => Branch::where('is_deleted','0')->pluck('name','id'), /* As of now Marketing Person is not dependent on branch */
            'link' => env('admin').'/marketing_person/'
        ];

        return View('admin.users.marketing_person.add',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Marketing Person Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request){
        $data = new MarketingPerson;

        if($data->validate($request->all(),"add")){
            return Redirect(env('admin').'/marketing_person/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }elseif($data->duplicateChk("add",$request)){
            return Redirect(env('admin').'/marketing_person/add')->with('error','Sorry! '.$data->duplicateChk("add",$request).' Already Exists')->withInput();
        }

        //$data->branch_id = $request->get('branch_id'); /* As of now Marketing Person is not dependent on branch */
        $data->name = $request->get('name');
        $data->email = strtolower($request->get('email'));
        $data->phone = $request->get('phone');
        $data->password = bcrypt($request->get('password'));
        $data->address = $request->get('address');
        $data->status = $request->get('status');
        $data->save();

        return Redirect(env('admin').'/marketing_person')->with('message','New Marketing Person Added Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Edit Marketing Person Page
    |------------------------------------------------------------------
    */
    public function edit($id){
        $data = [
            'id' => $id,
            'data' => MarketingPerson::find($id),
            //'branch' => Branch::pluck('name','id'), /* As of now Marketing Person is not dependent on branch */
            'link' => env('admin').'/marketing_person/'
        ];

        return View('admin.users.marketing_person.edit',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Marketing Person Data Update
    |------------------------------------------------------------------
    */
    public function update(Request $request,$id){
        $data = MarketingPerson::find($id);

        if($data->validate($request->all(),"edit")){
            return Redirect(env('admin').'/marketing_person/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }elseif($data->duplicateChk("edit",$request,$id)){
            return Redirect(env('admin').'/marketing_person/'.$id.'/edit')->with('error','Sorry! '.$data->duplicateChk("edit",$request,$id).' Already Exists')->withInput();
        }

        //$data->branch_id = $request->get('branch_id'); /* As of now Marketing Person is not dependent on branch */
        $data->name = $request->get('name');
        $data->email = strtolower($request->get('email'));
        $data->phone = $request->get('phone');
        $data->address = $request->get('address');
        $data->status = $request->get('status');
        
        if($request->get('password')){
            $data->password = bcrypt($request->get('password'));
        }

        $data->save();

        return Redirect(env('admin').'/marketing_person')->with('message','Marketing Person Updated Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Marketing Person Data Delete
    |------------------------------------------------------------------
    */
    public function destroy($id){
        $data = MarketingPerson::find($id);
        $data->is_deleted = 1;
        $data->save();

        return Redirect(env('admin').'/marketing_person')->with('message','Marketing Person Deleted Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Marketing Person Trash List Page
    |------------------------------------------------------------------
    */
    public function trash(){
        $data = [
            'data' => MarketingPerson::where('is_deleted','1')->get(),
            //'branch' => new Branch, /* As of now Marketing Person is not dependent on branch */
            'task' => new Task,
            'link' => env('admin').'/marketing_person/'
        ];

        return View('admin.users.marketing_person.trash',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Marketing Person Data Restore
    |------------------------------------------------------------------
    */
    public function restore($id){
        $data = MarketingPerson::find($id);
        $data->is_deleted = 0;
        $data->save();

        return Redirect(env('admin').'/marketing_person/trash')->with('message','Marketing Person Restored Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Marketing Person Data Delete Parmanently
    |------------------------------------------------------------------
    */
    public function destroyPermanent($id){
        $data = MarketingPerson::find($id);
        $data->delete();

        return Redirect(env('admin').'/marketing_person/trash')->with('message','Marketing Person Deleted Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Add Task Page for Marketing Person
    |------------------------------------------------------------------
    */
    public function addTask($id){
        $data = [
            'data' => Task::where('marketing_person_id',$id)->where('status','0')->first() ?? new Task,
            'marketing_person' => MarketingPerson::find($id),
            'task_comment' => new TaskComment,
            'link' => env('admin').'/marketing_person/'
        ];

        return View('admin.users.marketing_person.add_task',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Task Store for Marketing Person
    |------------------------------------------------------------------
    */
    public function addTaskStore(Request $request,$id){
        $data = Task::where('marketing_person_id',$id)->where('status','0')->first() ?? new Task;
        $marketing_person = MarketingPerson::find($id);

        if($data->validate($request->all())){
            return Redirect(env('admin').'/marketing_person/'.$id.'/add_task')->withErrors($data->validate($request->all()))->withInput();
        }

        $data->marketing_person_id = $id;
        $data->task_desc = $request->get('task_desc');
        $data->start_date = $request->get('start_date');
        $data->end_date = $request->get('end_date');
        $data->save();

        return Redirect(env('admin').'/marketing_person/'.$id.'/add_task')->with('message','Task Added on '.$marketing_person->name.' Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Finish Task for Marketing Person
    |------------------------------------------------------------------
    */
    public function finishTask(Request $request,$id){
        $marketing_person = MarketingPerson::find($id);
        $data = Task::where('marketing_person_id',$id)->where('status','0')->update(['status' => '1']);

        return Redirect(env('admin').'/marketing_person')->with('message','Task Finished on '.$marketing_person->name.' Successfully.');
    }
}
