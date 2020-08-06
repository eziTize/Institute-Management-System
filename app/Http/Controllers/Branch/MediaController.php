<?php

namespace App\Http\Controllers\Branch;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Media;

class MediaController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Media List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $data = [
            'data' => Media::get(),
            'link' => env('branch').'/media/'
        ];

        return View('branch.media.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Media Add Page
    |------------------------------------------------------------------
    */
    public function show(){
        $data = [
            'data' => new Media,
            'link' => env('branch').'/media/'
        ];

        return View('branch.media.add',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Media Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request){
        $data = new Media;

        if($data->validate($request->all(),"add")){
            return Redirect(env('branch').'/media')->withErrors($data->validate($request->all(),"add"))->withInput();
        }

        $upload = Media::addNew([
            'media_name' => $request->get('media_name'),
            'media_file' => $request->file('media_file')
        ]);

        if($upload){
            return Redirect(env('branch').'/media')->with('message','Media Added Successfully');
        }else{
            return Redirect(env('branch').'/media')->with('error','Sorry! Media Addition Failed')->withInput();
        }
    }

    /*
    |------------------------------------------------------------------
    |   Edit Media Page
    |------------------------------------------------------------------
    */
    public function edit($id){
        $data = [
            'id' => $id,
            'data' => Media::find($id),
            'link' => env('branch').'/media/'
        ];

        return View('branch.media.edit',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Media Data Update
    |------------------------------------------------------------------
    */
    public function update(Request $request,$id){
        $data = new Media;

        if($data->validate($request->all(),"edit")){
            return Redirect(env('branch').'/media/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }

        $upload = Media::updateExist([
            'id' => $id,
            'media_name' => $request->get('media_name'),
            'media_file' => $request->file('media_file') ?? ''
        ]);

        if($upload){
            return Redirect(env('branch').'/media/'.$id.'/edit')->with('message','Media Updated Successfully');
        }else{
            return Redirect(env('branch').'/media/'.$id.'/edit')->with('error','Sorry! Media Updation Failed')->withInput();
        }
    }

    /*
    |------------------------------------------------------------------
    |   Media Data Delete
    |------------------------------------------------------------------
    */
    public function destroy($id){
        Media::deleteDoc($id);

        return Redirect(env('branch').'/media')->with('message','Media Deleted Successfully.');
    }
}
