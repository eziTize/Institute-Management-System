<?php

namespace App\Http\Controllers\Tpo;

use App\Seminar;
use App\Http\Controllers\Controller;
use Auth;
use App\SeminarImg;
use Illuminate\Http\Request;
use Redirect;

class FashionShowController extends Controller
{

     /*
    |------------------------------------------------------------------
    |   Fashion Show List Page
    |------------------------------------------------------------------
    */

    public function index()
    {
        //
        $tpo_id = Auth::guard('tpo')->user()->id;
        
        $data = [
            'data' => Seminar::where('tpo_id', $tpo_id)->where('is_deleted', 0)->where('type', 'fashion-show')->get(),
            'fields' => new SeminarImg,
            'link' => env('tpo').'/fashion-show/'
        ];

        return View('tpo.fashion-show.index',$data);
    }


    /*
    |------------------------------------------------------------------
    |   Fashion Show Create Page
    |------------------------------------------------------------------
    */

    public function create()
    {
        //

        $data = [
            'data' => new Seminar,
            'link' => env('tpo').'/fashion-show/'
        ];

        return View('tpo.fashion-show.add',$data);
    }

 
    /*
    |------------------------------------------------------------------
    |   Fashion Show Store Data
    |------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        
       $tpo_id = Auth::guard('tpo')->user()->id;

       
        
        $data =  new Seminar;

        if($data->validate($request->all(),"add")){
            return Redirect(env('tpo').'/fashion-show/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }

        $data->tpo_id = $tpo_id;
		
		$data->type = 'fashion-show';


        $data->sm_name = $request->input('sm_name');

        $data->date = $request->input('date');
        $data->t_plan = $request->input('t_plan');
        $data->budget = $request->input('budget');
        $data->expense = $request->input('expense');
        $data->remarks = $request->input('remarks');
        $data->ph_no = $request->input('ph_no');
        $data->closure = $request->input('closure');
        $data->save();
        
        return Redirect(env('tpo').'/fashion-show')->with('message','New Fashion Show Added Successfully.');
    }

   

    /*
    |------------------------------------------------------------------
    |   Fashion Show Edit Page
    |------------------------------------------------------------------
    */

    public function edit($id)
    {
        //
        $seminar = Seminar::findOrFail($id);

        if ( Auth::guard('tpo')->user()->id == $seminar->tpo_id) {

         $data = [
            'id' => $id,
            'data' => Seminar::findOrFail($id),
            'fields' => SeminarImg::where('seminar_id',$id)->get(),
            'link' => env('tpo').'/fashion-show/'
        ];


            return View('tpo.fashion-show.edit',$data);

        }

        return back()->withErros('You do not have access to this!');
    }


    /*
    |------------------------------------------------------------------
    |   Fashion Show Update Data
    |------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        //
        $tpo_id = Auth::guard('tpo')->user()->id;
        
        $data =  Seminar::findOrFail($id);


       
      if($data->validate($request->all(),"edit")){
            return Redirect(env('tpo').'/fashion-show/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }

        $data->tpo_id = $tpo_id;

        $data->sm_name = $request->input('sm_name');


        $data->date = $request->input('date');
        $data->t_plan = $request->input('t_plan');
        $data->budget = $request->input('budget');
        $data->expense = $request->input('expense');
        $data->remarks = $request->input('remarks');
        $data->ph_no = $request->input('ph_no');
        $data->closure = $request->input('closure');
        $data->save();

          if($request->file('img_file')){
            foreach($request->file('img_file') as $img_key=>$img_file){
                SeminarImg::addNew([
                    'id' => $data->id,
                    'img_name' => $request->get('img_name')[$img_key],
                    'img_file' => $img_file
                ]);
            }
        }
        
        return Redirect(env('tpo').'/fashion-show')->with('message','Fashion Show Updated Successfully.');
    }

 
    /*
    |------------------------------------------------------------------
    |   Fashion Show Delete (Trash Data)
    |------------------------------------------------------------------
    */

    public function destroy($id)
    {
        //

        $tpo_id = Auth::guard('tpo')->user()->id;
        $seminar = Seminar::findOrFail($id);

        if ( $tpo_id == $seminar->tpo_id) {

            $data = Seminar::findOrFail($id);
            $data->is_deleted = 1;
            $data->save();

            return Redirect(env('tpo').'/fashion-show')->with('message','Fashion Show Deleted Successfully.');

        }

        return back()->withErros('You do not have access to this!');


    }


     /*
    |------------------------------------------------------------------
    |   Fashion Show Image Upload Field Add
    |------------------------------------------------------------------
    */

    public function addUploadField(){
        return View('tpo.fashion-show.upload_field');
    }
    
    /*
    |------------------------------------------------------------------
    |   Fashion Show Image Upload Field Delete
    |------------------------------------------------------------------
    */

    public function deleteUploadField($id){
        SeminarImg::deleteImg($id);

        return Redirect::back()->with('message','Removed Successfully.');
    }


     /*
    |------------------------------------------------------------------
    |   Fashion Show Upload Image Page
    |------------------------------------------------------------------
    */
    public function uploadImage($id)
    {
        //
        $seminar = Seminar::findOrFail($id);

        if ( Auth::guard('tpo')->user()->id == $seminar->tpo_id) {

         $data = [
            'id' => $id,
            'data' => Seminar::findOrFail($id),
            'fields' => SeminarImg::where('seminar_id',$id)->get(),
            'link' => env('tpo').'/fashion-show/'
        ];


            return View('tpo.fashion-show.upload',$data);

        }

        return back()->withErros('You do not have access to this!');
    }

    /*
    |------------------------------------------------------------------
    |   Fashion Show Store Uploaded Image Data
    |------------------------------------------------------------------
    */
    public function storeImage(Request $request, $id)
    {
        //
        
        $data =  Seminar::findOrFail($id);


          if($request->file('img_file')){
            foreach($request->file('img_file') as $img_key=>$img_file){
                SeminarImg::addNew([
                    'id' => $data->id,
                    'img_name' => $request->get('img_name')[$img_key],
                    'img_file' => $img_file
                ]);
            }
        }
        
        return Redirect(env('tpo').'/fashion-show')->with('message','Image(s) Uploaded Successfully.');
    }
}
