<?php

namespace App\Http\Controllers\Branch;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\BranchCourse;
use App\Course;
use App\Batch;

class CourseController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Course List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $branch_id = Auth::guard('branch')->user()->id;
        
        $data = [
            'data' => BranchCourse::where('branch_id',$branch_id)->where('status','Y')->get(),
            'course' => new Course,
            'link' => env('branch').'/course/'
        ];

        return View('branch.course.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Edit Course Page
    |------------------------------------------------------------------
    */
    public function edit($id){
        $branch_id = Auth::guard('branch')->user()->id;
        
        $data = [
            'id' => $id,
            'data' => BranchCourse::courseView($branch_id,$id),
            'link' => env('branch').'/course/'
        ];

        return View('branch.course.edit',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Get All the Batches for a Selected Course
    |------------------------------------------------------------------
    */
    public function getBatch($id){
        $batch = Batch::where('branch_course_id',$id)->get();

        return $batch;
    }
}
