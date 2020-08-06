<?php

namespace App\Http\Controllers\Admin;

use App\Marksheet;
use App\Http\Controllers\Controller;
use App\Student;
use App\Batch;
use App\StudentCourse;
use App\Course;
use App\Branch;
use Illuminate\Http\Request;
use App\Notification;


class MarksheetController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Marksheet List Page
    |------------------------------------------------------------------
    */
    public function index()
    {
         $data = [
            'data' => Marksheet::where('is_deleted', 0)->get(),
            'student' => Student::get(),
            'batch' => Batch::get(),
            'branch' => Branch::get(),
            'student_course' => StudentCourse::get(),
            'course' => Course::get(),

            'link' => env('admin').'/marksheet/'
        ];
        return View('admin.marksheet.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Marksheet Add Page
    |------------------------------------------------------------------
    */
    public function create()
    {
         $data = [
            'data' => new Marksheet,
            'student' => Student::where('is_deleted', 0)->get(),
            'batch' => Batch::get(),
            'branch' => Branch::get(),
            'student_course' => StudentCourse::get(),
            'course' => Course::get(),
            'link' => env('admin').'/marksheet/'
        ];

        return View('admin.marksheet.add',$data);
    }

    
    /*
    |------------------------------------------------------------------
    |   Marksheet Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $data =  new Marksheet;

       // $data->validate($request->all());

        $data->student_id = $request->input('student_id');
        $data->course_name = $request->input('course_name');
        $data->batch_id = $request->input('batch_id');
      
        $data->session = $request->input('session');
        $data->semester = $request->input('semester');

        $data->msheet_no = $request->input('msheet_no');
        $data->roll_no = $request->input('roll_no');

        $data->mtwe_fm = $request->input('mtwe_fm');
        $data->mtwe_om = $request->input('mtwe_om');

        $data->tswe_fm = $request->input('tswe_fm');
        $data->tswe_om = $request->input('tswe_om');

        $data->sp_fm = $request->input('sp_fm');
        $data->sp_om = $request->input('sp_om');

        $data->viva_fm = $request->input('viva_fm');
        $data->viva_om = $request->input('viva_om');

        $data->ft_fm = $request->input('ft_fm');
        $data->ft_om = $request->input('ft_om');


        $data->save();

      


        $notification = new Notification;

        $notification->student_id = $request->input('student_id');

        $notification->message = 'A new Marksheet has been generated for you';

        $notification->save();




       return Redirect(env('admin').'/marksheet')->with('message','Marksheet Created Successfully.');
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

            'link' => env('admin').'/marksheet/'
        ];

        return View('admin.marksheet.single',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Edit Marksheet Page
    |------------------------------------------------------------------
    */
    public function edit($id)
    {
         $data = [
            'id' => $id,
            'data' => Marksheet::findOrFail($id),
            'student' => Student::where('is_deleted', 0)->get(),
            'batch' => Batch::get(),
            'branch' => Branch::get(),
            'student_course' => StudentCourse::get(),
            'course' => Course::get(),
            'link' => env('admin').'/marksheet/'
        ];

        return View('admin.marksheet.edit',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Update Marksheet
    |------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $data =  Marksheet::findOrFail($id);

       // $data->validate($request->all());

        $data->student_id = $request->input('student_id');
        $data->course_name = $request->input('course_name');
        $data->batch_id = $request->input('batch_id');
      
        $data->session = $request->input('session');
        $data->semester = $request->input('semester');

        $data->msheet_no = $request->input('msheet_no');
        $data->roll_no = $request->input('roll_no');

        $data->mtwe_fm = $request->input('mtwe_fm');
        $data->mtwe_om = $request->input('mtwe_om');

        $data->tswe_fm = $request->input('tswe_fm');
        $data->tswe_om = $request->input('tswe_om');

        $data->sp_fm = $request->input('sp_fm');
        $data->sp_om = $request->input('sp_om');

        $data->viva_fm = $request->input('viva_fm');
        $data->viva_om = $request->input('viva_om');

        $data->ft_fm = $request->input('ft_fm');
        $data->ft_om = $request->input('ft_om');


        $data->save();


        $notification = new Notification;

        $notification->student_id = $request->input('student_id');

        $notification->message = 'Your Marksheet has been updated recently';

        $notification->save();




       return Redirect(env('admin').'/marksheet')->with('message','Marksheet Updated Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Marksheet Delete (Trash Data)
    |------------------------------------------------------------------
    */
    public function destroy($id)
    {
        //
        $data = Marksheet::findOrFail($id);
        $data->is_deleted = 1;
        $data->save();

        return Redirect(env('admin').'/marksheet')->with('message','Marksheet Deleted Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Marksheet Trash List Page
    |------------------------------------------------------------------
    */
    public function trash(){
        $data = [
            'data' => Marksheet::where('is_deleted', 1)->get(),
            'student' => Student::get(),
            'batch' => Batch::get(),
            'branch' => Branch::get(),
            'student_course' => StudentCourse::get(),
            'course' => Course::get(),

            'link' => env('admin').'/marksheet/'
        ];

        return View('admin.marksheet.trash',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Marksheet Restore
    |------------------------------------------------------------------
    */
    public function restore($id){
        $data = Marksheet::findOrFail($id);
        $data->is_deleted = 0;
        $data->save();

        return Redirect(env('admin').'/marksheet/trash')->with('success_message','Marksheet Restored Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Marksheet Delete (Permanent)
    |------------------------------------------------------------------
    */
    public function destroyPermanent($id){
        $data = Marksheet::findOrFail($id);
        $data->delete();

        return Redirect(env('admin').'/marksheet/trash')->with('message','Marksheet Deleted Successfully.');
    }
}
