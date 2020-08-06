<?php

namespace App\Http\Controllers\Branch;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Teacher;
use App\Branch;

class TeacherController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Teacher List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $branch_id = Auth::guard('branch')->user()->id;
        
        $data = [
            'data' => Teacher::where('branch_id', $branch_id)->where('is_deleted','0')->get(),
            'link' => env('branch').'/teacher/'
        ];

        return View('branch.users.teacher.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Teacher Add Page
    |------------------------------------------------------------------
    */
    public function show(){
        $data = [
            'data' => new Teacher,
            'link' => env('branch').'/teacher/'
        ];

        return View('branch.users.teacher.add',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Teacher Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request){
        $branch_id = Auth::guard('branch')->user()->id;
        $request->request->add(['branch_id' => $branch_id]);

        $data = new Teacher;

        if($data->validate($request->all(),"add")){
            return Redirect(env('branch').'/teacher/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }elseif($data->duplicateChk("add",$request)){
            return Redirect(env('branch').'/teacher/add')->with('error','Sorry! '.$data->duplicateChk("add",$request).' Already Exists')->withInput();
        }

        $data->branch_id = $request->get('branch_id');
        $data->name = $request->get('name');
        $data->email = strtolower($request->get('email'));
        $data->phone = $request->get('phone');
        $data->password = bcrypt($request->get('password'));
        $data->address = $request->get('address');
        $data->status = $request->get('status');
        $data->save();

        return Redirect(env('branch').'/teacher')->with('message','New Teacher Added Successfully.');
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
            'link' => env('branch').'/teacher/'
        ];

        return View('branch.users.teacher.edit',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Teacher Data Update
    |------------------------------------------------------------------
    */
    public function update(Request $request,$id){
        $branch_id = Auth::guard('branch')->user()->id;
        $request->request->add(['branch_id' => $branch_id]);

        $data = Teacher::find($id);

        if($data->validate($request->all(),"edit")){
            return Redirect(env('branch').'/teacher/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }elseif($data->duplicateChk("edit",$request,$id)){
            return Redirect(env('branch').'/teacher/'.$id.'/edit')->with('error','Sorry! '.$data->duplicateChk("edit",$request,$id).' Already Exists')->withInput();
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

        return Redirect(env('branch').'/teacher')->with('message','Teacher Updated Successfully.');
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

        return Redirect(env('branch').'/teacher')->with('message','Teacher Deleted Successfully.');
    }
}
