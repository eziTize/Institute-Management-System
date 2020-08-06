<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\StudentHelpdesk;

class FeedbacksController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Student Helpdesk Feedbacks Add Page
    |------------------------------------------------------------------
    */
    public function show(){
        $data = [
            'data' => new StudentHelpdesk,
            'link' => env('student').'/feedbacks'
        ];

        return View('student.helpdesk.feedbacks.add',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Student Helpdesk Feedbacks Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request){
        $student_id = Auth::guard('student')->user()->id;
        $request->request->add([
            'student_id' => $student_id,
            'type' => 'feedbacks'
        ]);
        
        $data = new StudentHelpdesk;

        if($data->validate($request->all(),"add")){
            return Redirect(env('student').'/feedbacks/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }

        $data->student_id = $request->get('student_id');
        $data->type = $request->get('type');
        $data->title = $request->get('title');
        $data->description = $request->get('description');
        $data->save();

        return Redirect(env('student').'/feedbacks/add')->with('message','Feedbacks Gave Successfully');
    }
}
