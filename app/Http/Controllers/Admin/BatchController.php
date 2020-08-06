<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Batch;
use App\BranchCourse;
use App\Branch;
use App\Course;

class BatchController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Batch List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $data = [
            'data' => Batch::where('is_deleted','0')->get(),
            'link' => env('admin').'/batch/'
        ];

        return View('admin.batch.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Batch Add Page
    |------------------------------------------------------------------
    */
    public function show(){
        $data = [
            'data' => new Batch,
            'branch_course' => BranchCourse::where('fee', '>', '0')->where('status', 'Y')->get(),
            'branch' => new Branch,
            'course' => new Course,
            'link' => env('admin').'/batch/'
        ];

        return View('admin.batch.add',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Batch Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request){
        $data = new Batch;

        if($data->validate($request->all(),"add")){
            return Redirect(env('admin').'/batch/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }elseif($data->duplicateChk("add",$request)){
            return Redirect(env('admin').'/batch/add')->with('error','Sorry! '.$data->duplicateChk("add",$request).' Already Exists')->withInput();
        }

        $data->branch_course_id = $request->get('branch_course');
        $data->name = $request->get('name');
        $data->status = $request->get('status');
        $data->save();

        return Redirect(env('admin').'/batch')->with('message','New Batch Added Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Edit Batch Page
    |------------------------------------------------------------------
    */
    public function edit($id){
        $data = [
            'id' => $id,
            'data' => Batch::batchView($id),
            'link' => env('admin').'/batch/'
        ];

        return View('admin.batch.edit',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Batch Data Update
    |------------------------------------------------------------------
    */
    public function update(Request $request,$id){
        $data = Batch::find($id);

        if($data->validate($request->all(),"edit")){
            return Redirect(env('admin').'/batch/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }elseif($data->duplicateChk("edit",$request,$id)){
            return Redirect(env('admin').'/batch/'.$id.'/edit')->with('error','Sorry! '.$data->duplicateChk("edit",$request,$id).' Already Exists')->withInput();
        }
        
        $data->name = $request->get('name');
        $data->status = $request->get('status');
        $data->save();

        return Redirect(env('admin').'/batch')->with('message','Batch Updated Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Batch Data Delete
    |------------------------------------------------------------------
    */
    public function destroy($id){
        $data = Batch::find($id);
        $data->is_deleted = 1;
        $data->save();

        return Redirect(env('admin').'/batch')->with('message','Batch Deleted Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Batch Trash List Page
    |------------------------------------------------------------------
    */
    public function trash(){
        $data = [
            'data' => Batch::where('is_deleted','1')->get(),
            'link' => env('admin').'/batch/'
        ];

        return View('admin.batch.trash',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Batch Data Restore
    |------------------------------------------------------------------
    */
    public function restore($id){
        $data = Batch::find($id);
        $data->is_deleted = 0;
        $data->save();

        return Redirect(env('admin').'/batch/trash')->with('message','Batch Restored Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Batch Data Delete Parmanently
    |------------------------------------------------------------------
    */
    public function destroyPermanent($id){
        $data = Batch::find($id);
        $data->delete();

        return Redirect(env('admin').'/batch/trash')->with('message','Batch Deleted Successfully.');
    }
}
