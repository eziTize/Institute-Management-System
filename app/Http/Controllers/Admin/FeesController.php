<?php

namespace App\Http\Controllers\Admin;


use App\Fees;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Batch;
use App\BranchCourse;
use App\Course;
use App\ExtraFees;

class FeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*
    |------------------------------------------------------------------
    |   Fees List Page
    |------------------------------------------------------------------
    */
    public function index()
    {
        //

        $data = [
            'data' => Fees::where('is_deleted','0')->get(),
            'student' => Student::get(),
            'link' => env('admin').'/fees/'
        ];
        return View('admin.fees.index',$data);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Fees  $fees
     * @return \Illuminate\Http\Response
     */
    /*
    |------------------------------------------------------------------
    |   Single Fee Page
    |------------------------------------------------------------------
    */
    public function show($id)
    {
        //

         $data = [
            'id' => $id,
            'data' => Fees::findOrFail($id),
            'student' => Student::get(),
            'link' => env('admin').'/fees/'
        ];

        return View('admin.fees.single',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Fees Add Page
    |------------------------------------------------------------------
    */
    public function create()
    {

     $data = [
            'data' => new Fees,
            'student' => Student::get(),
            'link' => env('admin').'/fees/'
        ];

        return View('admin.fees.add',$data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /*
    |------------------------------------------------------------------
    |   Fees Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $data =  new Fees;

        $data->validate($request->all());

        $data->student_id = $request->input('student_id');

        $data->description = $request->input('description');
      
        $data->fee = $request->input('fee');
       
        $data->fee_date = $request->input('fee_date');

        $data->save();
       return Redirect(env('admin').'/fees')->with('message','New Fee Created Successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fees  $fees
     * @return \Illuminate\Http\Response
     */
    /*
    |------------------------------------------------------------------
    |   Fee Delete (Trash Data)
    |------------------------------------------------------------------
    */
    public function destroy($id)
    {
        //
        $data = Fees::findOrFail($id);
        $data->is_deleted = 1;
        $data->save();

        return Redirect(env('admin').'/fees')->with('message','Fee Deleted Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Fee Trash List Page
    |------------------------------------------------------------------
    */
    public function trash(){
        $data = [
            'data' => Fees::where('is_deleted','1')->get(),
            'student' => Student::get(),
            'batch' => Batch::where('is_deleted', '0')->where('status', '0')->get(),
            'branch_course' => BranchCourse::where('fee', '>', '0')->where('status', 'Y')->get(),
            'course' => Course::where('is_deleted', '0')->where('status', '0')->get(),
            'link' => env('admin').'/fees/'
        ];

        return View('admin.fees.trash',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Fee Data Restore
    |------------------------------------------------------------------
    */
    public function restore($id){
        $data = Fees::findOrFail($id);
        $data->is_deleted = false;
        $data->save();

        return Redirect(env('admin').'/fees/trash')->with('success_message','Fee Restored Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Fee Data Delete (Permanent)
    |------------------------------------------------------------------
    */
    public function destroyPermanent($id){
        $data = Fees::findOrFail($id);
        $data->delete();

        return Redirect(env('admin').'/fees/trash')->with('message','Fee Deleted Successfully.');
    }
         
}
