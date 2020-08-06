<?php

namespace App\Http\Controllers\Student;

use App\Marksheet;
use App\Http\Controllers\Controller;
use App\Student;
use App\Batch;
use App\StudentCourse;
use App\Course;
use App\Branch;
use Illuminate\Http\Request;
use App\Notification;
use Auth;


class MarksheetController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Marksheet List Page
    |------------------------------------------------------------------
    */
    public function index()
    {

        $student_id = Auth::guard('student')->user()->id;

         $data = [
            'data' => Marksheet::where('is_deleted', 0)->where('student_id', $student_id)->get(),
            'student' => Student::get(),
            'batch' => Batch::get(),
            'branch' => Branch::get(),
            'student_course' => StudentCourse::get(),
            'course' => Course::get(),

            'link' => env('student').'/marksheet/'
        ];
        return View('student.marksheet.index',$data);
    }



    /*
    |------------------------------------------------------------------
    |   Single Marksheet Page
    |------------------------------------------------------------------
    */
    public function show($id)
    {


        $marksheet = Marksheet::findOrFail($id);
         $m_total_fm = $marksheet->mtwe_fm + $marksheet->tswe_fm + $marksheet->sp_fm;
         $m_total_om = $marksheet->mtwe_om + $marksheet->tswe_om + $marksheet->sp_om;
         $pcnt = $m_total_om / $m_total_fm * 100;

         $data = [
            'id' => $id,
            'data' => $marksheet,
            'student' => Student::get(),
            'batch' => Batch::get(),
            'branch' => Branch::get(),
            'student_course' => StudentCourse::get(),
            'course' => Course::get(),
            'm_total_fm' => $m_total_fm,
            'm_total_om' => $m_total_om,
            'percent' => $pcnt,

            'link' => env('student').'/marksheet/'
        ];


        if ( Auth::guard('student')->user()->id == $marksheet->student_id) {

            return View('student.marksheet.single',$data);

        }

            return back()->withErros('You do not have access to this!');

    }
}
