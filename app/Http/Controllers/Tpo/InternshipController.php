<?php

namespace App\Http\Controllers\Tpo;

use App\Seminar;
use App\Http\Controllers\Controller;
use Auth;
use App\SeminarImg;
use Illuminate\Http\Request;
use Redirect;

class InternshipController extends Controller
{

    /*
    |------------------------------------------------------------------
    |   Internship List Page
    |------------------------------------------------------------------
    */

    public function index()
    {
        //
        $tpo_id = Auth::guard('tpo')->user()->id;
        
        $data = [
            'data' => Seminar::where('tpo_id', $tpo_id)->where('is_deleted', 0)->where('type', 'internship')->get(),
            'fields' => new SeminarImg,
            'link' => env('tpo').'/internship/'
        ];

        return View('tpo.internship.index',$data);
    }


    /*
    |------------------------------------------------------------------
    |   Internship Create Page
    |------------------------------------------------------------------
    */

    public function create()
    {
        //

        $data = [
            'data' => new Seminar,
            'link' => env('tpo').'/internship/'
        ];

        return View('tpo.internship.add',$data);
    }

 
    /*
    |------------------------------------------------------------------
    |   Internship Store Data
    |------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        
       $tpo_id = Auth::guard('tpo')->user()->id;

       
        
        $data =  new Seminar;

        if($data->validate($request->all(),"add")){
            return Redirect(env('tpo').'/internship/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }

        $data->tpo_id = $tpo_id;
		
		$data->type = 'internship';


        $data->sm_name = $request->input('sm_name');

        $data->date = $request->input('date');
        $data->t_plan = $request->input('t_plan');
        $data->budget = $request->input('budget');
        $data->expense = 0.00;
        $data->remarks = $request->input('remarks');
        $data->ph_no = $request->input('ph_no');
        $data->closure = $request->input('closure');
        $data->save();
        
        return Redirect(env('tpo').'/internship')->with('message','New Internship Added Successfully.');
    }

   

    /*
    |------------------------------------------------------------------
    |   Internship Edit Page
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
            'link' => env('tpo').'/internship/'
        ];


            return View('tpo.internship.edit',$data);

        }

        return back()->withErros('You do not have access to this!');
    }


    /*
    |------------------------------------------------------------------
    |   Internship Update Data
    |------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        //
        $tpo_id = Auth::guard('tpo')->user()->id;
        
        $data =  Seminar::findOrFail($id);


       
      if($data->validate($request->all(),"edit")){
            return Redirect(env('tpo').'/internship/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }

        $data->tpo_id = $tpo_id;

        $data->sm_name = $request->input('sm_name');


        $data->date = $request->input('date');
        $data->t_plan = $request->input('t_plan');
        $data->budget = $request->input('budget');
        $data->expense = 0.00;
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
        
        return Redirect(env('tpo').'/internship')->with('message','Internship Updated Successfully.');
    }

 
    /*
    |------------------------------------------------------------------
    |   Internship Delete (Trash Data)
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

            return Redirect(env('tpo').'/internship')->with('message','Internship Deleted Successfully.');

        }

        return back()->withErros('You do not have access to this!');


    }


     /*
    |------------------------------------------------------------------
    |   Internship Image Upload Field Add
    |------------------------------------------------------------------
    */

    public function addUploadField(){
        return View('tpo.internship.upload_field');
    }
    
    /*
    |------------------------------------------------------------------
    |   Internship Image Upload Field Delete
    |------------------------------------------------------------------
    */

    public function deleteUploadField($id){
        SeminarImg::deleteImg($id);

        return Redirect::back()->with('message','Removed Successfully.');
    }


     /*
    |------------------------------------------------------------------
    |   Internship Upload Image Page
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
            'link' => env('tpo').'/internship/'
        ];


            return View('tpo.internship.upload',$data);

        }

        return back()->withErros('You do not have access to this!');
    }

    /*
    |------------------------------------------------------------------
    |   Internship Store Uploaded Image Data
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
        
        return Redirect(env('tpo').'/internship')->with('message','Image(s) Uploaded Successfully.');
    }
}
