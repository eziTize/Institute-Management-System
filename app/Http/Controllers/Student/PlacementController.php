<?php

namespace App\Http\Controllers\Student;;

use App\Openings;
use App\Student;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use App\OpeningsStudent;
use App\Notification;
use Illuminate\Http\Request;
use Response;

class PlacementController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   List Openings Page
    |------------------------------------------------------------------
    */

    public function index()
    {
        
        
        $data = [
            'data' => Openings::where('is_deleted', 0)->where('is_active', 1)->get(),
            'link' => env('student').'/openings/'
        ];

        return View('student.openings.index',$data);
    }



 	/*
    |------------------------------------------------------------------
    |   Apply for Opening
    |------------------------------------------------------------------
    */

     public function applyforOpening(Request $request, $id)
    {

    	$student_id = Auth::guard('student')->user()->id;
        $openings = Openings::findOrFail($id);
       
       
        $data =  new OpeningsStudent;
        $data->student_id = $student_id;
        $data->openings_id = $openings->id;

        $cv_file = time().'.'.request()->cv_file->getClientOriginalExtension();

        $data->cv_file = $cv_file;
        $data->save();

        request()->cv_file->move("upload/student_cv/", $cv_file);


        $notification = new Notification;
        $notification->tpo_id = $openings->tpo_id;
        $notification->message = 'You have received an application for '.$openings->o_type;
        $notification->save();

        
        return Redirect(env('student').'/openings')->with('message','Applied for Opening Successfully.');

    }


    /*
    |------------------------------------------------------------------
    |   Apply for Opening Page
    |------------------------------------------------------------------
    */

    public function SendApplication($id)
    {



        
        $openings = Openings::findOrFail($id);

        $student_id = Auth::guard('student')->user()->id;

        $student = Student::findOrFail($student_id);



if (OpeningsStudent::where('openings_id', $openings->id )->where('student_id', $student_id)->count() > 0) {


    $data = [
        
            'link' => env('student').'/openings/',

        ];
    return View('student.openings.applied', $data);
}

         $data = [

            'id' => $id,
            'data' => $openings,
            'link' => env('student').'/openings/',
            'student' => $student,

        ];

        return View('student.openings.apply',$data);
    }


    /*
    |------------------------------------------------------------------
    |   Show Single Opening Page
    |------------------------------------------------------------------
    */
    public function show($id)
    {
        

          $data = [
            'id' => $id,
            'data' => Openings::findOrFail($id),
            'link' => env('student').'/openings/'
        ];


            return View('student.openings.single',$data);
    }


    /*
    |------------------------------------------------------------------
    |   List Offered Jobs
    |------------------------------------------------------------------
    */

    public function jobOffers()
    {
        
        
        $student_id = Auth::guard('student')->user()->id;
    
        $op_students = OpeningsStudent::where('student_id', $student_id)->where('offer', 'Sent')->get();


         $data = [
            'data' => $op_students,
            'link' => env('student').'/openings/',
            'openings' => Openings::where('is_deleted', 0)->where('is_active', 1)->get(),
            'student' => Auth::guard('student'),
        ];

        return View('student.openings.offered',$data);
    }


    /*
    |------------------------------------------------------------------
    |   Dowload Offer Letter
    |------------------------------------------------------------------
    */
    public function downloadOfferLetter($id)
    {

            $op_students = OpeningsStudent::findOrFail($id);

            $file_path = 'upload/offer_letters/'. $op_students->file_name;

            if($op_students->file_name == null) {

                return Redirect(env('student').'/job-offers')->with('error','No File Found.');


            }
            return Response::download($file_path);

    }

}
