<?php

namespace App\Http\Controllers\Branch;

use App\Openings;
use App\Tpo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;

class OpeningsController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   List Openings Page
    |------------------------------------------------------------------
    */

    public function index()
    {
        
        
        $data = [
            'data' => Openings::where('is_deleted', 0)->get(),
            'tpo' => Tpo::all(),
            'link' => env('branch').'/openings/'
        ];

        return View('branch.openings.index',$data);
    }


    /*
    |------------------------------------------------------------------
    |   Edit Opening Page
    |------------------------------------------------------------------
    */

    public function edit($id)
    {
        //

         $data = [
            'id' => $id,
            'data' => Openings::findOrFail($id),
            'link' => env('branch').'/openings/'
        ];


            return View('branch.openings.edit',$data);

    }

    /*
    |------------------------------------------------------------------
    |   Update Opening Data
    |------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        //
        
        $data =  Openings::findOrFail($id);
       
      if($data->validate($request->all(),"edit")){
           return Redirect(env('branch').'/openings/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }

        $data->company_name = $request->input('company_name');
        $data->company_details = $request->input('company_details');
        $data->date = $request->input('date');

        $data->o_type = $request->input('o_type');
        $data->o_details = $request->input('o_details');
        $data->max_salary = $request->input('max_salary');
        $data->min_salary = $request->input('min_salary');

        $data->intake_cap = $request->input('intake_cap');
        $data->contact = $request->input('contact');

        $data->eligibility = $request->input('eligibility');

        $data->is_active = $request->input('is_active');

        $data->save();
        
        return Redirect(env('branch').'/openings')->with('message','Opening Updated Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Opening Delete (Trash Data)
    |------------------------------------------------------------------
    */

    public function destroy($id)
    {

            $data = Openings::findOrFail($id);

            $data->is_deleted = 1;
            $data->save();

            return Redirect(env('branch').'/openings')->with('message','Opening Deleted Successfully.');
    }
}
