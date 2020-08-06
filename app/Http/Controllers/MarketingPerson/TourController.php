<?php

namespace App\Http\Controllers\MarketingPerson;

use App\Seminar;
use App\Http\Controllers\Controller;
use Auth;
use App\SeminarImg;
use Illuminate\Http\Request;
use Redirect;

class TourController extends Controller
{


     /*
    |------------------------------------------------------------------
    |   Tour List Page
    |------------------------------------------------------------------
    */

    public function index()
    {
        //
        $mkt_id = Auth::guard('marketing_person')->user()->id;
        
        $data = [
            'data' => Seminar::where('mkt_id', $mkt_id)->where('is_deleted', 0)->where('type', 'tour')->get(),
            'fields' => new SeminarImg,
            'link' => env('marketing_person').'/tour/'
        ];

        return View('marketing_person.tour.index',$data);
    }


    /*
    |------------------------------------------------------------------
    |   Tour Create Page
    |------------------------------------------------------------------
    */

    public function create()
    {
        //

        $data = [
            'data' => new Seminar,
            //'student' => Student::get(),
            'link' => env('marketing_person').'/tour/'
        ];

        return View('marketing_person.tour.add',$data);
    }

 
    /*
    |------------------------------------------------------------------
    |   Tour Store Data
    |------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        
       $mkt_id = Auth::guard('marketing_person')->user()->id;

       
        
        $data =  new Seminar;

        if($data->validate($request->all(),"add")){
            return Redirect(env('marketing_person').'/tour/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }

        $data->mkt_id = $mkt_id;
        
        $data->type = 'tour';


        $data->sm_name = $request->input('sm_name');

        $data->date = $request->input('date');
        $data->t_plan = $request->input('t_plan');
        $data->budget = $request->input('budget');
        $data->expense = $request->input('expense');
        $data->remarks = $request->input('remarks');
        $data->ph_no = $request->input('ph_no');
        $data->closure = $request->input('closure');
        $data->save();
        
        return Redirect(env('marketing_person').'/tour')->with('message','New Tour Added Successfully.');
    }

   

    /*
    |------------------------------------------------------------------
    |   Tour Edit Page
    |------------------------------------------------------------------
    */

    public function edit($id)
    {
        //
        $seminar = Seminar::findOrFail($id);

        if ( Auth::guard('marketing_person')->user()->id == $seminar->mkt_id) {

         $data = [
            'id' => $id,
            'data' => Seminar::findOrFail($id),
            'fields' => SeminarImg::where('seminar_id',$id)->get(),
            'link' => env('marketing_person').'/tour/'
        ];


            return View('marketing_person.tour.edit',$data);

        }

        return back()->withErros('You do not have access to this!');
    }


    /*
    |------------------------------------------------------------------
    |   Tour Update Data
    |------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        //
        $mkt_id = Auth::guard('marketing_person')->user()->id;
        
        $data =  Seminar::findOrFail($id);


       
      if($data->validate($request->all(),"edit")){
            return Redirect(env('marketing_person').'/tour/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }

        $data->mkt_id = $mkt_id;

        $data->sm_name = $request->input('sm_name');


        $data->date = $request->input('date');
        $data->t_plan = $request->input('t_plan');
        $data->budget = $request->input('budget');
        $data->expense = $request->input('expense');
        $data->remarks = $request->input('remarks');
        $data->ph_no = $request->input('ph_no');
        $data->closure = $request->input('closure');
        $data->save();
        
        return Redirect(env('marketing_person').'/tour')->with('message','Tour Updated Successfully.');
    }

 
    /*
    |------------------------------------------------------------------
    |   Tour Delete (Trash Data)
    |------------------------------------------------------------------
    */

    public function destroy($id)
    {
        //

        $mkt_id = Auth::guard('marketing_person')->user()->id;
        $seminar = Seminar::findOrFail($id);

        if ( $mkt_id == $seminar->mkt_id) {

            $data = Seminar::findOrFail($id);
            $data->is_deleted = 1;
            $data->save();

            return Redirect(env('marketing_person').'/tour')->with('message','Tour Deleted Successfully.');

        }

        return back()->withErros('You do not have access to this!');


    }


     /*
    |------------------------------------------------------------------
    |   Tour Image Upload Field Add
    |------------------------------------------------------------------
    */

    public function addUploadField(){
        return View('marketing_person.tour.upload_field');
    }
    
    /*
    |------------------------------------------------------------------
    |   Tour Image Upload Field Delete
    |------------------------------------------------------------------
    */

    public function deleteUploadField($id){
        SeminarImg::deleteImg($id);

        return Redirect::back()->with('message','Removed Successfully.');
    }


     /*
    |------------------------------------------------------------------
    |   Tour Upload Image Page
    |------------------------------------------------------------------
    */
    public function uploadImage($id)
    {
        //
        $seminar = Seminar::findOrFail($id);

        if ( Auth::guard('marketing_person')->user()->id == $seminar->mkt_id) {

         $data = [
            'id' => $id,
            'data' => Seminar::findOrFail($id),
            'fields' => SeminarImg::where('seminar_id',$id)->get(),
            'link' => env('marketing_person').'/tour/'
        ];


            return View('marketing_person.tour.upload',$data);

        }

        return back()->withErros('You do not have access to this!');
    }

    /*
    |------------------------------------------------------------------
    |   Tour Store Uploaded Image Data
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
        
        return Redirect(env('marketing_person').'/tour')->with('message','Image(s) Uploaded Successfully.');
    }
}

