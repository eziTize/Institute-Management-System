<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EnquirySrc;

class EnquirySrcController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Enquiry Source List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $data = [
            'data' => EnquirySrc::where('is_deleted','0')->get(),
            'link' => env('admin').'/enquiry_src/'
        ];

        return View('admin.enquiry_src.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Enquiry Source Add Page
    |------------------------------------------------------------------
    */
    public function show(){
        $data = [
            'data' => new EnquirySrc,
            'link' => env('admin').'/enquiry_src/'
        ];

        return View('admin.enquiry_src.add',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Enquiry Source Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request){
        $data = new EnquirySrc;

        if($data->validate($request->all())){
            return Redirect(env('admin').'/enquiry_src/add')->withErrors($data->validate($request->all()))->withInput();
        }elseif($data->duplicateChk("add",$request)){
            return Redirect(env('admin').'/enquiry_src/add')->with('error','Sorry! '.$data->duplicateChk("add",$request).' Already Exists')->withInput();
        }

        $data->name = $request->get('name');
        $data->status = $request->get('status');
        $data->save();

        return Redirect(env('admin').'/enquiry_src')->with('message','New Enquiry Source Added Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Edit Enquiry Source Page
    |------------------------------------------------------------------
    */
    public function edit($id){
        $data = [
            'id' => $id,
            'data' => EnquirySrc::find($id),
            'link' => env('admin').'/enquiry_src/'
        ];

        return View('admin.enquiry_src.edit',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Enquiry Source Data Update
    |------------------------------------------------------------------
    */
    public function update(Request $request,$id){
        $data = EnquirySrc::find($id);

        if($data->validate($request->all(),"edit")){
            return Redirect(env('admin').'/enquiry_src/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }elseif($data->duplicateChk("edit",$request,$id)){
            return Redirect(env('admin').'/enquiry_src/'.$id.'/edit')->with('error','Sorry! '.$data->duplicateChk("edit",$request,$id).' Already Exists')->withInput();
        }

        $data->name = $request->get('name');
        $data->status = $request->get('status');
        $data->save();

        return Redirect(env('admin').'/enquiry_src')->with('message','Enquiry Source Updated Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Enquiry Source Data Delete
    |------------------------------------------------------------------
    */
    public function destroy($id){
        $data = EnquirySrc::find($id);
        $data->is_deleted = 1;
        $data->save();

        return Redirect(env('admin').'/enquiry_src')->with('message','Enquiry Source Deleted Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Enquiry Source Trash List Page
    |------------------------------------------------------------------
    */
    public function trash(){
        $data = [
            'data' => EnquirySrc::where('is_deleted','1')->get(),
            'link' => env('admin').'/enquiry_src/'
        ];

        return View('admin.enquiry_src.trash',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Enquiry Source Data Restore
    |------------------------------------------------------------------
    */
    public function restore($id){
        $data = EnquirySrc::find($id);
        $data->is_deleted = 0;
        $data->save();

        return Redirect(env('admin').'/enquiry_src/trash')->with('message','Enquiry Source Restored Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Enquiry Source Data Delete Parmanently
    |------------------------------------------------------------------
    */
    public function destroyPermanent($id){
        $data = EnquirySrc::find($id);
        $data->delete();

        return Redirect(env('admin').'/enquiry_src/trash')->with('message','Enquiry Source Deleted Successfully.');
    }
}
