<?php

namespace App\Http\Controllers\Admin;

use App\ExtraFees;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExtraFeesController extends Controller
{
  
    /*
    |------------------------------------------------------------------
    |   Extra Fees List Page
    |------------------------------------------------------------------
    */

    public function index()
    {
        //
        $data = [
            'data' => ExtraFees::get(),
            'link' => env('admin').'/fee-settings/'
        ];

        return View('admin.fee-settings.index',$data);
    }

  
    /*
    |------------------------------------------------------------------
    |   Extra Fees Edit Page
    |------------------------------------------------------------------
    */
    public function edit($slug)
    {
        //
        $data = [
            'id' => $slug,
            'data' => ExtraFees::where('slug', $slug)->firstOrFail(),
            'link' => env('admin').'/fee-settings/'
        ];

        return View('admin.fee-settings.edit',$data);
    }


    /*
    |------------------------------------------------------------------
    |   Extra Fees Update Data
    |------------------------------------------------------------------
    */
    public function update(Request $request,$slug)
    {
        //
        $data = ExtraFees::where('slug', $slug)->firstOrFail();
        
        if($data->validate($request->all())){
            return Redirect(env('admin').'/fee-settings/'.$slug.'/edit')->withErrors($data->validate($request->all()))->withInput();
        }elseif($data->duplicateChk($request,$slug)){
            return Redirect(env('admin').'/fee-settings/'.$slug.'/edit')->with('error','Sorry! '.$data->duplicateChk($request,$slug).' Already Exists')->withInput();
        }

        $data->fee_type = $request->get('fee_type');
        $data->fee_amount = $request->get('fee_amount');
        $data->save();

        return Redirect(env('admin').'/fee-settings')->with('message','Fee Updated Successfully.');
    }

}
