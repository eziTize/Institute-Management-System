<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Course;

class CourseController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Course List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $data = [
            'data' => Course::where('is_deleted','0')->get(),
            'link' => env('admin').'/course/'
        ];

        return View('admin.course.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Course Add Page
    |------------------------------------------------------------------
    */
    public function show(){
        $data = [
            'data' => new Course,
            'link' => env('admin').'/course/'
        ];

        return View('admin.course.add',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Course Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request){
        $data = new Course;

        if($data->validate($request->all(),"add")){
            return Redirect(env('admin').'/course/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }elseif($data->duplicateChk("add",$request)){
            return Redirect(env('admin').'/course/add')->with('error','Sorry! '.$data->duplicateChk("add",$request).' Already Exists')->withInput();
        }

        $data->name = $request->get('name');
        $data->duration = $request->get('duration');
        $data->status = $request->get('status');
        $data->save();

        return Redirect(env('admin').'/course')->with('message','New Course Added Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Edit Course Page
    |------------------------------------------------------------------
    */
    public function edit($id){
        $data = [
            'id' => $id,
            'data' => Course::find($id),
            'link' => env('admin').'/course/'
        ];

        return View('admin.course.edit',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Course Data Update
    |------------------------------------------------------------------
    */
    public function update(Request $request,$id){
        $data = Course::find($id);

        if($data->validate($request->all(),"edit")){
            return Redirect(env('admin').'/course/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }elseif($data->duplicateChk("edit",$request,$id)){
            return Redirect(env('admin').'/course/'.$id.'/edit')->with('error','Sorry! '.$data->duplicateChk("edit",$request,$id).' Already Exists')->withInput();
        }
        
        $data->name = $request->get('name');
        $data->duration = $request->get('duration');
        $data->status = $request->get('status');
        $data->save();

        return Redirect(env('admin').'/course')->with('message','Course Updated Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Course Data Delete
    |------------------------------------------------------------------
    */
    public function destroy($id){
        $data = Course::find($id);
        $data->is_deleted = 1;
        $data->save();

        return Redirect(env('admin').'/course')->with('message','Course Deleted Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Course Trash List Page
    |------------------------------------------------------------------
    */
    public function trash(){
        $data = [
            'data' => Course::where('is_deleted','1')->get(),
            'link' => env('admin').'/course/'
        ];

        return View('admin.course.trash',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Course Data Restore
    |------------------------------------------------------------------
    */
    public function restore($id){
        $data = Course::find($id);
        $data->is_deleted = 0;
        $data->save();

        return Redirect(env('admin').'/course/trash')->with('message','Course Restored Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Course Data Delete Parmanently
    |------------------------------------------------------------------
    */
    public function destroyPermanent($id){
        $data = Course::find($id);
        $data->delete();

        return Redirect(env('admin').'/course/trash')->with('message','Course Deleted Successfully.');
    }
}
