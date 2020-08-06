<?php

namespace App\Http\Controllers\Branch;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use IMS;
use Carbon\Carbon;
use App\Student;
use App\Branch;
use App\StudentDoc;
use App\Course;
use App\BranchCourse;
use App\StudentCourse;
use App\Batch;
use App\ExtraFees;
use App\Fees;

class StudentController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Student List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $branch_id = Auth::guard('branch')->user()->id;
        
        $data = [
            'data' => Student::where('branch_id', $branch_id)->where('is_deleted','0')->get(),
            'fields' => new StudentDoc,
            'link' => env('branch').'/student/'
        ];

        return View('branch.users.student.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Student Add Page
    |------------------------------------------------------------------
    */
    public function show(){
        $data = [
            'data' => new Student,
            'extra-fees' => ExtraFees::all(),
            'link' => env('branch').'/student/'
        ];

        return View('branch.users.student.add',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Student Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request){
        $branch_id = Auth::guard('branch')->user()->id;
        $request->request->add(['branch_id' => $branch_id]);
        
        $data = new Student;

        if($data->validate($request->all(),"add")){
            return Redirect(env('branch').'/student/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }

        $data->branch_id = $request->get('branch_id');
        $data->name = $request->get('name');
        $data->father_name = $request->get('father_name');
        $data->mother_name = $request->get('mother_name');
        $data->dob = $request->get('dob');
        $data->phone = $request->get('phone');
        $data->other_contact = $request->get('other_contact');
        $data->email = $request->get('email');
        $data->gender = $request->get('gender');
        $data->state = $request->get('state');
        $data->city = $request->get('city');
        $data->address = $request->get('address');
        $data->save();

        $data->login_id = IMS::generate_student_login_id($data->id);
        $data->save();

        if($request->file('doc_file')){
            foreach($request->file('doc_file') as $doc_key=>$doc_file){
                StudentDoc::addNew([
                    'id' => $data->id,
                    'doc_type' => $request->get('doc_type')[$doc_key],
                    'doc_file' => $doc_file
                ]);
            }
        }

        return Redirect(env('branch').'/student/makeAdmission/'.$data->id);

    }

    /*
    |------------------------------------------------------------------
    |   Edit Student Page
    |------------------------------------------------------------------
    */
    public function edit($id){
        $data = [
            'id' => $id,
            'data' => Student::find($id),
            'extra_fees' => ExtraFees::all(),
            'fields' => StudentDoc::where('student_id',$id)->get(),
            'link' => env('branch').'/student/'
        ];

        return View('branch.users.student.edit',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Student Data Update
    |------------------------------------------------------------------
    */
    public function update(Request $request,$id){
        $branch_id = Auth::guard('branch')->user()->id;
        $request->request->add(['branch_id' => $branch_id]);

        $data = Student::find($id);

        if($data->validate($request->all(),"edit")){
            return Redirect(env('branch').'/student/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }

        $data->branch_id = $request->get('branch_id');
        $data->name = $request->get('name');
        $data->father_name = $request->get('father_name');
        $data->mother_name = $request->get('mother_name');
        $data->dob = $request->get('dob');
        $data->phone = $request->get('phone');
        $data->other_contact = $request->get('other_contact');
        $data->email = $request->get('email');
        $data->gender = $request->get('gender');
        $data->state = $request->get('state');
        $data->city = $request->get('city');
        $data->address = $request->get('address');

        if($data->admission_date){
            $data->admission_date = $request->get('admission_date');
        }

        $data->save();

        $data->login_id = IMS::generate_student_login_id($data->id);
        $data->save();

        if($request->file('doc_file')){
            foreach($request->file('doc_file') as $doc_key=>$doc_file){
                StudentDoc::addNew([
                    'id' => $data->id,
                    'doc_type' => $request->get('doc_type')[$doc_key],
                    'doc_file' => $doc_file
                ]);
            }
        }

        return Redirect(env('branch').'/student')->with('message','Student Updated Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Student Data Delete
    |------------------------------------------------------------------
    */
    public function destroy($id){
        $data = Student::find($id);
        $data->is_deleted = 1;
        $data->save();

        return Redirect(env('branch').'/student')->with('message','Student Deleted Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Student Document Upload Field Add
    |------------------------------------------------------------------
    */
    public function addUploadField(){
        return View('branch.users.student.upload_field');
    }
    
    /*
    |------------------------------------------------------------------
    |   Student Document Upload Field Delete
    |------------------------------------------------------------------
    */
    public function deleteUploadField($id){
        StudentDoc::deleteDoc($id);

        return Redirect::back()->with('message','Removed Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Student Admission Page
    |------------------------------------------------------------------
    */
    public function makeAdmission($id){
        $branch_id = Auth::guard('branch')->user()->id;
        
        $data = [
            'id' => $id,
            'data' => Student::find($id),
            'course' => new Course,
            'branch_course' => BranchCourse::where('branch_id',$branch_id)->where('status','Y')->get(),
            'extra_fees' => ExtraFees::get(),
            'link' => env('branch').'/student/'
        ];
        
        return View('branch.users.student.make_admission',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Student Admission Action
    |------------------------------------------------------------------
    */
    public function makeAdmissionAction(Request $request,$id){
        $branch_id = Auth::guard('branch')->user()->id;
     //   $request->request->add(['branch_id' => $branch_id]);
       // $request->request->add(['student_id' => $id]);

        $data = Student::find($id);

        

        $data1 = new StudentCourse;
        $data1->student_id = $data->id;
        $data1->branch_course_id = $request->get('branch_course');
        $data1->batch_id = $request->get('batch');
        $data1->course_join = $request->get('course_join');
        $data1->admission_date = $request->get('admission_date');


        $branch_course = BranchCourse::find($request->get('branch_course'));
        $course = BranchCourse::courseView($branch_id,$branch_course->course_id);

        $data1->admission_fee = $request->input('admission_fee');
        $data1->ppts_fee = $request->input('ppts_fee');
        $data1->sq_deposit = $request->input('sq_deposit');
        $data1->reg_fee = $request->input('reg_fee');
        $data1->discount = $request->input('discount');
        

        $data1->course_complete = IMS::get_course_finish_date($request->get('course_join'),$course->duration);
  

        $data1->installment = $request->input('installment');


        $brn_course = BranchCourse::where('fee', '>', '0')->where('status', 'Y')->get();
        $crs = Course::where('is_deleted', '0')->where('status', '0')->get();

        $data1->course_name = $crs->find($brn_course->find($request->get('branch_course'))->course_id)->name;

        if ( $request->input('installment') == 'One Time') {
            $data1->ot_fee = (($brn_course->find($request->get('branch_course'))->fee) - ($request->input('discount')))- ($request->input('reg_fee')) ;

        } else if ( $request->input('installment') == 'Monthly') {
            $data1->mt_fee = ((($brn_course->find($request->get('branch_course'))->fee) - ($request->input('discount'))) - ($request->input('reg_fee'))) / ($crs->find($brn_course->find($request->get('branch_course'))->course_id)->duration);
        } else {

            $data1->wk_fee = ((($brn_course->find($request->get('branch_course'))->fee ) - ($request->input('discount'))) - ($request->input('reg_fee'))) / (($crs->find($brn_course->find($request->get('branch_course'))->course_id)->duration) * 4 );

        }

        $data1->save();


        $fees1 = new Fees;
        $fees1->student_id = $data->id;
        $fees1->description = 'Registration Fee';
        $fees1->fee = $request->input('reg_fee');
        $fees1->fee_date = $request->input('admission_date');

        $fees1->save();



        $fees2 = new Fees;
        $fees2->student_id = $data->id;
        $fees2->description = 'Security Deposit';
        $fees2->fee = $request->input('sq_deposit');
        $fees2->fee_date = $request->input('admission_date');

        $fees2->save();



        $fees3 = new Fees;
        $fees3->student_id = $data->id;
        $fees3->description = 'Prospectus Fee';
        $fees3->fee = $request->input('ppts_fee');
        $fees3->fee_date = $request->input('admission_date');

        $fees3->save();




        $fees4 = new Fees;
        $fees4->student_id = $data->id;
        $fees4->description = 'Admission Fee';
        $fees4->fee = $request->input('admission_fee');
        $fees4->fee_date = $request->input('admission_date');

        $fees4->save();




        return Redirect(env('branch').'/student')->with('message','Student Admission is Successful.');
    }


     /*
    |------------------------------------------------------------------
    |   Student Course Details Page
    |------------------------------------------------------------------
    */
        public function CourseDetails($id)
                {
                    //

                     $data = [
                        'id' => $id,
                        'data' => StudentCourse::where('student_id',$id)->get(),
                        'student' => Student::get(),
                        'batch' => Batch::where('is_deleted', '0')->where('status', '0')->get(),
                        'branch_course' => BranchCourse::where('fee', '>', '0')->where('status', 'Y')->get(),
                        'course' => Course::where('is_deleted', '0')->where('status', '0')->get(),
                        'link' => env('branch').'/student/',
                    ];

                    return View('branch.users.student.course-details',$data);
                }
            
    /*
    |------------------------------------------------------------------
    |   Change Course Page
    |------------------------------------------------------------------
    
    public function changeCourse($id){
        $branch_id = Auth::guard('branch')->user()->id;
        
        $data = [
            'id' => $id,
            'data' => Student::find($id),
            'course' => new Course,
            'single_branch_course' => new BranchCourse,
            'batch' => new Batch,
            'branch_course' => BranchCourse::where('branch_id',$branch_id)->where('status','Y')->get(),
            'student_course' => StudentCourse::where('student_id', $id)->orderby('course_join', 'desc')->get(),
            'curr_student_course' => StudentCourse::where('student_id', $id)->where('course_complete', '>', Carbon::today())->first(),
            'today' => Carbon::today(),
            'link' => env('branch').'/student/'
        ];
        
        return View('branch.users.student.change_course',$data);
    }
    */

    /*
    |------------------------------------------------------------------
    |   Change Course Action
    |------------------------------------------------------------------
    
    public function changeCourseAction(Request $request,$id){
        $branch_id = Auth::guard('branch')->user()->id;

        if(StudentCourse::where('student_id',$id)->where('course_complete', '>', Carbon::today())->exists()){
            $std_courses = StudentCourse::where('student_id',$id)->where('course_complete', '>', Carbon::today())->get();
            foreach($std_courses as $std_course){
                if($std_course->course_join > Carbon::today()){
                    $std_course->delete();
                }else{
                    $std_course->course_complete = $request->get('course_join');
                    $std_course->save();
                }
            }
        }

        $data = new StudentCourse;
        $data->student_id = $id;
        $data->branch_course_id = $request->get('branch_course');
        $data->batch_id = $request->get('batch');
        $data->course_join = $request->get('course_join');

        $branch_course = BranchCourse::find($request->get('branch_course'));
        $course = BranchCourse::courseView($branch_id,$branch_course->course_id);

        $data->course_complete = IMS::get_course_finish_date($request->get('course_join'),$course->duration);
        $data->save();

        return Redirect(env('branch').'/student')->with('message','Course Changed Successfully.');
    }
    */

    /*
    |------------------------------------------------------------------
    |   Change Batch Page
    |------------------------------------------------------------------
    */
    public function changeBatch(Request $request,$id){

        $branch = Auth::guard('branch')->user();
        $branch_id = $branch->id;

        $branch_course = BranchCourse::where('branch_id',$branch_id)->where('status','Y')->get();

        $student = Student::get();

        $course = Course::where('is_deleted', '0')->where('status', '0')->get();


        $scr = StudentCourse::findOrFail($id);
        $student_id = $student->find($scr->student_id)->id;

        $data = [

            'id' => $id,
            'branch_id' => $branch_id,
            'branch' => Auth::guard('branch')->user(),
            'data' => StudentCourse::findOrFail($id),
            'student' => $student,
            'branch_course' => $branch_course,
            'batch' => Batch::where('is_deleted', '0')->where('status', '0')->get(),
            'course' => $course,
            'today' => Carbon::today(),
            'extra_fees' => ExtraFees::get(),

            'link' => env('branch').'/student/'.$student_id.'/course-details',
        ];
        
        return View('branch.users.student.change_course_batch',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Change Batch Action
    |------------------------------------------------------------------
    */


    public function changeBatchAction(Request $request,$id){

        $branch_id = Auth::guard('branch')->user()->id;

        $student = Student::get();



        $data = StudentCourse::findOrFail($id);

        $data->batch_id = $request->input('batch_id');

        $student_id = $student->find($data->student_id)->id;

        $data->save();

        return Redirect(env('branch').'/student/'.$student_id.'/course-details')->with('message','Batch Changed Successfully.');
    }


    /*
    |------------------------------------------------------------------
    |   Stop Course Action
    |------------------------------------------------------------------
    */


        public function stopCourse($id){

        $data = StudentCourse::findOrFail($id);

        $student = Student::get();

        $student_id = $student->find($data->student_id)->id;


        $data->c_status = 'Incomplete';

        $data->save();

        return Redirect(env('branch').'/student/'.$student_id.'/course-details')->with('message','Course Stopped Successfully.');
    }



    /*
    |------------------------------------------------------------------
    |   Single Course View for Student
    |------------------------------------------------------------------
    */


        public function singleCourseView($id){

        $data = StudentCourse::findOrFail($id);

        $student = Student::get();

        $student_id = $student->find($data->student_id)->id;


       $data = [
                        'id' => $id,
                        'data' => StudentCourse::findOrFail($id),
                        'student' => Student::where('id',$student_id)->get(),
                        'student_id' => $student_id,
                        'batch' => Batch::where('is_deleted', '0')->where('status', '0')->get(),
                        'branch_course' => BranchCourse::where('fee', '>', '0')->where('status', 'Y')->get(),
                        'course' => Course::where('is_deleted', '0')->where('status', '0')->get(),
                        'link' => env('branch').'/student/',
                    ];


        return View('branch.users.student.single-course',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Get the ID Card for Student
    |------------------------------------------------------------------
    */
    public function getIDCard($id){
        $student = Student::findOrFail($id);

        if($student->photograph && $student->blood_group){
            $student_course = StudentCourse::where('student_id',$id)->where('course_complete', '>=', Carbon::today())->firstOrFail();
            $batch = Batch::findOrFail($student_course->batch_id);
            $branch_course = BranchCourse::findOrFail($batch->branch_course_id);

            $data = [
                'id' => $id,
                'data' => $student,
                'batch' => $batch,
                'course' => Course::findOrFail($branch_course->id),
                'student_course' => $student_course,
                'link' => env('branch').'/student/'
            ];

            return View('branch.users.student.get_id_card',$data);
        }else{
            return Redirect(env('branch').'/student/generateIDCard/'.$id);
        }
    }

    /*
    |------------------------------------------------------------------
    |   Print the ID Card for Student
    |------------------------------------------------------------------
    */
    public function printIDCard($id){
        $student = Student::findOrFail($id);

        if($student->photograph && $student->blood_group){
            $student_course = StudentCourse::where('student_id',$id)->where('course_complete', '>=', Carbon::today())->firstOrFail();
            $batch = Batch::findOrFail($student_course->batch_id);
            $branch_course = BranchCourse::findOrFail($batch->branch_course_id);

            $data = [
                'id' => $id,
                'data' => $student,
                'batch' => $batch,
                'course' => Course::findOrFail($branch_course->id),
                'student_course' => $student_course,
                'link' => env('branch').'/student/'
            ];

            return View('branch.users.student.print_id_card',$data);
        }else{
            return Redirect(env('branch').'/student/generateIDCard/'.$id);
        }
    }

    /*
    |------------------------------------------------------------------
    |   Generate the ID Card Page for Student
    |------------------------------------------------------------------
    */
    public function generateIDCard($id){
        $data = [
            'id' => $id,
            'data' => Student::findOrFail($id),
            'student_course' => StudentCourse::where('student_id',$id)->where('course_complete', '>=', Carbon::today())->firstOrFail(),
            'link' => env('branch').'/student/'
        ];

        return View('branch.users.student.generate_id_card',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Generate the ID Card Action for Student
    |------------------------------------------------------------------
    */
    public function generateIDCardAction(Request $request,$id){
        $student = Student::findOrFail($id);

        if(!$student->photograph || $request->file('photograph')){
            $upload = Student::addNew([
                'id' => $id,
                'photograph' => $request->file('photograph')
            ]);
        }else{
            $upload = true;
        }

        if($upload){
            $student->name = $request->name;
            $student->blood_group = $request->blood_group;
            $student->save();

            return Redirect(env('branch').'/student/getIDCard/'.$id)->with('message','ID Card Generated Successfully.');
        }else{
            return Redirect(env('branch').'/student/generateIDCard/'.$id)->with('error','Sorry! Photo Upload Failed')->withInput();
        }
    }
    
}
