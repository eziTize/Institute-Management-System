<?php

namespace App\Http\Controllers\MarketingPerson;

use App\Seminar;
use App\Http\Controllers\Controller;
use Auth;
use App\SeminarImg;
use Illuminate\Http\Request;
use Redirect;

class SeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*
    |------------------------------------------------------------------
    |   Seminars List Page
    |------------------------------------------------------------------
    */
    public function index()
    {
        //
        $mkt_id = Auth::guard('marketing_person')->user()->id;
        
        $data = [
            'data' => Seminar::where('mkt_id', $mkt_id)->where('is_deleted', 0)->where('type', 'seminar')->get(),
            'fields' => new SeminarImg,
            'link' => env('marketing_person').'/seminars/'
        ];

        return View('marketing_person.seminar.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*
    |------------------------------------------------------------------
    |   Seminars Create Page
    |------------------------------------------------------------------
    */
    public function create()
    {
        //

        $data = [
            'data' => new Seminar,
            //'student' => Student::get(),
            'link' => env('marketing_person').'/seminars/'
        ];

        return View('marketing_person.seminar.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*
    |------------------------------------------------------------------
    |   Seminars Store Data
    |------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        
       $mkt_id = Auth::guard('marketing_person')->user()->id;

       
        
        $data =  new Seminar;

        if($data->validate($request->all(),"add")){
            return Redirect(env('marketing_person').'/seminars/add')->withErrors($data->validate($request->all(),"add"))->withInput();
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

        
        return Redirect(env('marketing_person').'/seminars')->with('message','New Seminar Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Seminar  $seminar
     * @return \Illuminate\Http\Response
     */
    /*
    |------------------------------------------------------------------
    |   Seminars Show  Single Data
    |------------------------------------------------------------------
    
    public function show($id)
    {
        //

        $seminar = Seminar::all();


        if ( Auth::guard('tpo')->user()->id == $seminar->tpo_id) {

         $data = [
            'id' => $id,
            'data' => Seminar::findOrFail($id),
            'images' => SeminarImg::where('seminar_id',$id)->get(),
            'link' => env('tpo').'/seminars/'
        ];


            return View('tpo.seminar.single',$data);

        }


        return back()->withErros('You do not have access to this!');

        
    }
    */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Seminar  $seminar
     * @return \Illuminate\Http\Response
     */
    /*
    |------------------------------------------------------------------
    |   Seminars Edit Page
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
            'link' => env('marketing_person').'/seminars/'
        ];


            return View('marketing_person.seminar.edit',$data);

        }

        return back()->withErros('You do not have access to this!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seminar  $seminar
     * @return \Illuminate\Http\Response
     */
    /*
    |------------------------------------------------------------------
    |   Seminars Update Data
    |------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        //
        $mkt_id = Auth::guard('marketing_person')->user()->id;
        
        $data =  Seminar::findOrFail($id);


       
      if($data->validate($request->all(),"edit")){
            return Redirect(env('marketing_person').'/seminars/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
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
        
        return Redirect(env('marketing_person').'/seminars')->with('message','Seminar Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seminar  $seminar
     * @return \Illuminate\Http\Response
     */
    /*
    |------------------------------------------------------------------
    |   Seminar Delete (Trash Data)
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

            return Redirect(env('marketing_person').'/seminars')->with('message','Seminar Deleted Successfully.');

        }

        return back()->withErros('You do not have access to this!');


    }


     /*
    |------------------------------------------------------------------
    |   Seminar Image Upload Field Add
    |------------------------------------------------------------------
    */
    public function addUploadField(){
        return View('marketing_person.seminar.upload_field');
    }
    
    /*
    |------------------------------------------------------------------
    |   Seminar Image Upload Field Delete
    |------------------------------------------------------------------
    */
    public function deleteUploadField($id){
        SeminarImg::deleteImg($id);

        return Redirect::back()->with('message','Removed Successfully.');
    }


    /*
    |------------------------------------------------------------------
    |   Seminars Upload Image Page
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
            'link' => env('marketing_person').'/seminars/'
        ];


            return View('marketing_person.seminar.upload',$data);

        }

        return back()->withErros('You do not have access to this!');
    }

    /*
    |------------------------------------------------------------------
    |   Seminars Store Uploaded Image Data
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
        
        return Redirect(env('marketing_person').'/seminars')->with('message','Image(s) Uploaded Successfully.');
    }
}
