<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\StudentHelpdesk;

class ComplaintsController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Student Helpdesk Complaints Add Page
    |------------------------------------------------------------------
    */
    public function show(){
        $data = [
            'data' => new StudentHelpdesk,
            'link' => env('student').'/complaints'
        ];

        return View('student.helpdesk.complaints.add',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Student Helpdesk Complaints Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request){
        $student_id = Auth::guard('student')->user()->id;
        $request->request->add([
            'student_id' => $student_id,
            'type' => 'complaints'
        ]);
        
        $data = new StudentHelpdesk;

        if($data->validate($request->all(),"add")){
            return Redirect(env('student').'/complaints/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }

        $data->student_id = $request->get('student_id');
        $data->type = $request->get('type');
        $data->title = $request->get('title');
        $data->description = $request->get('description');
        $data->save();

        return Redirect(env('student').'/complaints/add')->with('message','Complaints Lodged Successfully');
    }
}
