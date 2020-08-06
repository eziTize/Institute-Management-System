<?php

namespace App\Http\Controllers\Branch;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Telecaller;
use App\Branch;

class TelecallerController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Telecaller List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $branch_id = Auth::guard('branch')->user()->id;
        
        $data = [
            'data' => Telecaller::where('branch_id', $branch_id)->where('is_deleted','0')->get(),
            'link' => env('branch').'/telecaller/'
        ];

        return View('branch.users.telecaller.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Telecaller Add Page
    |------------------------------------------------------------------
    */
    public function show(){
        $data = [
            'data' => new Telecaller,
            'link' => env('branch').'/telecaller/'
        ];

        return View('branch.users.telecaller.add',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Telecaller Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request){
        $branch_id = Auth::guard('branch')->user()->id;
        $request->request->add(['branch_id' => $branch_id]);

        $data = new Telecaller;

        if($data->validate($request->all(),"add")){
            return Redirect(env('branch').'/telecaller/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }elseif($data->duplicateChk("add",$request)){
            return Redirect(env('branch').'/telecaller/add')->with('error','Sorry! '.$data->duplicateChk("add",$request).' Already Exists')->withInput();
        }

        $data->branch_id = $request->get('branch_id');
        $data->name = $request->get('name');
        $data->email = strtolower($request->get('email'));
        $data->phone = $request->get('phone');
        $data->password = bcrypt($request->get('password'));
        $data->address = $request->get('address');
        $data->status = $request->get('status');
        $data->save();

        return Redirect(env('branch').'/telecaller')->with('message','New Telecaller Added Successfully.');
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
            'link' => env('branch').'/telecaller/'
        ];

        return View('branch.users.telecaller.edit',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Telecaller Data Update
    |------------------------------------------------------------------
    */
    public function update(Request $request,$id){
        $branch_id = Auth::guard('branch')->user()->id;
        $request->request->add(['branch_id' => $branch_id]);

        $data = Telecaller::find($id);

        if($data->validate($request->all(),"edit")){
            return Redirect(env('branch').'/telecaller/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }elseif($data->duplicateChk("edit",$request,$id)){
            return Redirect(env('branch').'/telecaller/'.$id.'/edit')->with('error','Sorry! '.$data->duplicateChk("edit",$request,$id).' Already Exists')->withInput();
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

        return Redirect(env('branch').'/telecaller')->with('message','Telecaller Updated Successfully.');
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

        return Redirect(env('branch').'/telecaller')->with('message','Telecaller Deleted Successfully.');
    }
}
