<?php

namespace App\Http\Controllers\Tpo;

use App\Seminar;
use App\Http\Controllers\Controller;
use Auth;
use App\SeminarImg;
use Illuminate\Http\Request;
use Redirect;

class MatSemController extends Controller
{

     /*
    |------------------------------------------------------------------
    |   Material Seminar List Page
    |------------------------------------------------------------------
    */

    public function index()
    {
        //
        $tpo_id = Auth::guard('tpo')->user()->id;
        
        $data = [
            'data' => Seminar::where('tpo_id', $tpo_id)->where('is_deleted', 0)->where('type', 'material-seminar')->get(),
            'fields' => new SeminarImg,
            'link' => env('tpo').'/material-seminar/'
        ];

        return View('tpo.material-seminar.index',$data);
    }


    /*
    |------------------------------------------------------------------
    |   Material Seminar Create Page
    |------------------------------------------------------------------
    */

    public function create()
    {
        //

        $data = [
            'data' => new Seminar,
            'link' => env('tpo').'/material-seminar/'
        ];

        return View('tpo.material-seminar.add',$data);
    }

 
    /*
    |------------------------------------------------------------------
    |   Material Seminar Store Data
    |------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        
       $tpo_id = Auth::guard('tpo')->user()->id;

       
        
        $data =  new Seminar;

        if($data->validate($request->all(),"add")){
            return Redirect(env('tpo').'/material-seminar/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }

        $data->tpo_id = $tpo_id;
		
		$data->type = 'material-seminar';


        $data->sm_name = $request->input('sm_name');

        $data->date = $request->input('date');
        $data->t_plan = $request->input('t_plan');
        $data->budget = $request->input('budget');
        $data->expense = $request->input('expense');
        $data->remarks = $request->input('remarks');
        $data->ph_no = $request->input('ph_no');
        $data->closure = $request->input('closure');
        $data->save();
        
        return Redirect(env('tpo').'/material-seminar')->with('message','New Material Seminar Added Successfully.');
    }

   

    /*
    |------------------------------------------------------------------
    |   Material Seminar Edit Page
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
            'link' => env('tpo').'/material-seminar/'
        ];


            return View('tpo.material-seminar.edit',$data);

        }

        return back()->withErros('You do not have access to this!');
    }


    /*
    |------------------------------------------------------------------
    |   Material Seminar Update Data
    |------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        //
        $tpo_id = Auth::guard('tpo')->user()->id;
        
        $data =  Seminar::findOrFail($id);


       
      if($data->validate($request->all(),"edit")){
            return Redirect(env('tpo').'/material-seminar/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
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
        
        return Redirect(env('tpo').'/material-seminar')->with('message','Material Seminar Updated Successfully.');
    }

 
    /*
    |------------------------------------------------------------------
    |   Material Seminar Delete (Trash Data)
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

            return Redirect(env('tpo').'/material-seminar')->with('message','Material Seminar Deleted Successfully.');

        }

        return back()->withErros('You do not have access to this!');


    }


     /*
    |------------------------------------------------------------------
    |   Material Seminar Image Upload Field Add
    |------------------------------------------------------------------
    */

    public function addUploadField(){
        return View('tpo.material-seminar.upload_field');
    }
    
    /*
    |------------------------------------------------------------------
    |   Material Seminar Image Upload Field Delete
    |------------------------------------------------------------------
    */

    public function deleteUploadField($id){
        SeminarImg::deleteImg($id);

        return Redirect::back()->with('message','Removed Successfully.');
    }


     /*
    |------------------------------------------------------------------
    |   Material Seminar Upload Image Page
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
            'link' => env('tpo').'/material-seminar/'
        ];


            return View('tpo.material-seminar.upload',$data);

        }

        return back()->withErros('You do not have access to this!');
    }

    /*
    |------------------------------------------------------------------
    |   Material Seminar Store Uploaded Image Data
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
        
        return Redirect(env('tpo').'/material-seminar')->with('message','Image(s) Uploaded Successfully.');
    }
}