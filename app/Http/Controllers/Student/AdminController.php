<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use App\Student;
use App\Task;
use App\StudentCourse;
use App\Batch;
use App\BranchCourse;
use App\Course;
use IMS;
use Carbon\Carbon;

class AdminController extends Controller
{
    
    /*
    |------------------------------------------------------------------
    |   Root Page
    |------------------------------------------------------------------
    */
    public function root(){
        if(Auth::guard('student')->check()){
            return Redirect(env('student').'/dashboard');
        }else{
            return Redirect(env('student').'/login');
        }
    }

    /*
    |------------------------------------------------------------------
    |   Login Page
    |------------------------------------------------------------------
    */
    public function index(){
        if(Auth::guard('student')->check()){
            return Redirect(env('student').'/dashboard');
        }else{
            return View('student.login');
        }
    }

    /*
    |------------------------------------------------------------------
    |   Login Check & Attempt
    |------------------------------------------------------------------
    */
    public function login(Request $request){
        $login_id = $request->input('login_id');

        if(Student::where('login_id',$login_id)->exists()){
            $user = Student::where('login_id',$login_id)->first();

            Auth::guard('student')->loginUsingId($user->id);

            if($user->status){
                Auth::guard('student')->logout();
                return Redirect(env('student').'/login')->with('error','Your Account is Blocked');
            }elseif($user->is_deleted){
                Auth::guard('student')->logout();
                return Redirect(env('student').'/login')->with('error','Invalid Credentials');
            }else{
                return Redirect(env('student').'/dashboard')->with('message','Welcome '.$user->name.'! You are logged in now');
            }
        }else{
            return Redirect(env('student').'/login')->with('error','Invalid Credentials');
        }
    }

    /*
    |------------------------------------------------------------------
    |   Logout
    |------------------------------------------------------------------
    */
    public function logout(){
        Auth::guard('student')->logout();
        return Redirect(env('student').'/login')->with('message','Successfully logged out');
    }

    /*
    |------------------------------------------------------------------
    |   Dashboard Page
    |------------------------------------------------------------------
    */
    public function dashboard(){
        $student_id = Auth::guard('student')->user()->id;

        $data = [];

        return View('student.dashboard',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Account Settings Page
    |------------------------------------------------------------------
    */
    public function settings(){
        $data = [
            'data' => Auth::guard('student')->user()
        ];
        
        return View('student.settings',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Update Account Settings
    |------------------------------------------------------------------
    */
    public function update(Request $request){
        $user_id = Auth::guard('student')->user()->id;
        $data = Student::find($user_id);

        if($data->validate($request->all(),"settings")){
            return Redirect(env('student').'/settings')->withErrors($data->validate($request->all(),"settings"))->withInput();
        }else{              
            $current_login_id = IMS::generate_student_login_id_prefix($data->id).$request->get('login_id');

            if($data->login_id != $current_login_id){
                return Redirect(env('student').'/settings')->with('error', 'Wrong Login ID');
            }else{
                $data->login_id = IMS::generate_student_login_id($data->id,$request->get('new_login_id'));
                $data->save();
                
                return Redirect(env('student').'/settings')->with('message', 'Your Login ID Changed Successfully');
            }
        }
    }

    /*
    |------------------------------------------------------------------
    |   Get the ID Card for Student
    |------------------------------------------------------------------
    */
    public function getIDCard(){
        $student_id = Auth::guard('student')->user()->id;
        $student = Student::findOrFail($student_id);

        if($student->photograph && $student->blood_group){
            $student_course = StudentCourse::where('student_id',$student_id)->where('course_complete', '>=', Carbon::today())->firstOrFail();
            $batch = Batch::findOrFail($student_course->batch_id);
            $branch_course = BranchCourse::findOrFail($batch->branch_course_id);

            $data = [
                'id' => $student_id,
                'data' => $student,
                'batch' => $batch,
                'course' => Course::findOrFail($branch_course->id),
                'student_course' => $student_course,
                'link' => env('student').'/'
            ];

            return View('student.id_card.get_id_card',$data);
        }else{
            $data = [
                'id' => $student_id,
                'data' => $student,
                'link' => env('student').'/'
            ];

            return View('student.id_card.get_id_card',$data);
        }
    }

    /*
    |------------------------------------------------------------------
    |   Print the ID Card for Student
    |------------------------------------------------------------------
    */
    public function printIDCard(){
        $student_id = Auth::guard('student')->user()->id;
        $student = Student::findOrFail($student_id);

        if($student->photograph && $student->blood_group){
            $student_course = StudentCourse::where('student_id',$student_id)->where('course_complete', '>=', Carbon::today())->firstOrFail();
            $batch = Batch::findOrFail($student_course->batch_id);
            $branch_course = BranchCourse::findOrFail($batch->branch_course_id);

            $data = [
                'id' => $student_id,
                'data' => $student,
                'batch' => $batch,
                'course' => Course::findOrFail($branch_course->id),
                'student_course' => $student_course,
                'link' => env('student').'/'
            ];

            return View('student.id_card.print_id_card',$data);
        }else{
            return Redirect(env('student').'/getIDCard');
        }
    }
}