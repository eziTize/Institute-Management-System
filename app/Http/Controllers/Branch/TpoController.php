<?php

namespace App\Http\Controllers\Branch;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Tpo;
use App\Branch;

class TpoController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Tpo List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $branch_id = Auth::guard('branch')->user()->id;
        
        $data = [
            'data' => Tpo::where('branch_id', $branch_id)->where('is_deleted','0')->get(),
            'link' => env('branch').'/tpo/'
        ];

        return View('branch.users.tpo.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Tpo Add Page
    |------------------------------------------------------------------
    */
    public function show(){
        $data = [
            'data' => new Tpo,
            'link' => env('branch').'/tpo/'
        ];

        return View('branch.users.tpo.add',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Tpo Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request){
        $branch_id = Auth::guard('branch')->user()->id;
        $request->request->add(['branch_id' => $branch_id]);
        
        $data = new Tpo;

        if($data->validate($request->all(),"add")){
            return Redirect(env('branch').'/tpo/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }elseif($data->duplicateChk("add",$request)){
            return Redirect(env('branch').'/tpo/add')->with('error','Sorry! '.$data->duplicateChk("add",$request).' Already Exists')->withInput();
        }

        $data->branch_id = $request->get('branch_id');
        $data->name = $request->get('name');
        $data->email = strtolower($request->get('email'));
        $data->phone = $request->get('phone');
        $data->password = bcrypt($request->get('password'));
        $data->address = $request->get('address');
        $data->status = $request->get('status');
        $data->save();

        return Redirect(env('branch').'/tpo')->with('message','New Tpo Added Successfully.');
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
            'link' => env('branch').'/tpo/'
        ];

        return View('branch.users.tpo.edit',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Tpo Data Update
    |------------------------------------------------------------------
    */
    public function update(Request $request,$id){
        $branch_id = Auth::guard('branch')->user()->id;
        $request->request->add(['branch_id' => $branch_id]);

        $data = Tpo::find($id);

        if($data->validate($request->all(),"edit")){
            return Redirect(env('branch').'/tpo/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }elseif($data->duplicateChk("edit",$request,$id)){
            return Redirect(env('branch').'/tpo/'.$id.'/edit')->with('error','Sorry! '.$data->duplicateChk("edit",$request,$id).' Already Exists')->withInput();
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

        return Redirect(env('branch').'/tpo')->with('message','Tpo Updated Successfully.');
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

        return Redirect(env('branch').'/tpo')->with('message','Tpo Deleted Successfully.');
    }
}
