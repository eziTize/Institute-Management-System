<?php

namespace App\Http\Controllers\Tpo;

use App\Openings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use App\OpeningsStudent;
use App\Student;
use App\Notification;
use Response;

class OpeningsController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   List Openings Page
    |------------------------------------------------------------------
    */

    public function index()
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;
        
        $data = [
            'data' => Openings::where('tpo_id', $tpo_id)->where('is_deleted', 0)->get(),
            'link' => env('tpo').'/openings/'
        ];

        return View('tpo.openings.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Create Openings Page
    |------------------------------------------------------------------
    */

    public function create()
    {
        //
        $data = [
            'data' => new Openings,
            'link' => env('tpo').'/openings/'
        ];

        return View('tpo.openings.add',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Store Openings Data
    |------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;

        $data =  new Openings;

       if($data->validate($request->all(),"add")){
            return Redirect(env('tpo').'/openings/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }


        $data->tpo_id = $tpo_id;

        $data->company_name = $request->input('company_name');
        $data->company_details = $request->input('company_details');
        $data->date = $request->input('date');

        $data->o_type = $request->input('o_type');
        $data->o_details = $request->input('o_details');
        $data->max_salary = $request->input('max_salary');
        $data->min_salary = $request->input('min_salary');

        $data->intake_cap = $request->input('intake_cap');
        $data->contact = $request->input('contact');

        $data->eligibility = $request->input('eligibility');

        $data->is_active = $request->input('is_active');

        $data->save();
        
        return Redirect(env('tpo').'/openings')->with('message','New Opening Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Openings  $openings
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    
    }

    /*
    |------------------------------------------------------------------
    |   Edit Openings Page
    |------------------------------------------------------------------
    */

    public function edit($id)
    {
        //
         $opening = Openings::findOrFail($id);

        if ( Auth::guard('tpo')->user()->id == $opening->tpo_id) {

         $data = [
            'id' => $id,
            'data' => Openings::findOrFail($id),
            'link' => env('tpo').'/openings/'
        ];


            return View('tpo.openings.edit',$data);

        }

        return back()->withErros('You do not have access to this!');
    }

    /*
    |------------------------------------------------------------------
    |   Update Openings Data
    |------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        //
        $tpo_id = Auth::guard('tpo')->user()->id;
        
        $data =  Openings::findOrFail($id);


       
      if($data->validate($request->all(),"edit")){
           return Redirect(env('tpo').'/openings/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }

        $data->tpo_id = $tpo_id;

        $data->company_name = $request->input('company_name');
        $data->company_details = $request->input('company_details');
        $data->date = $request->input('date');

        $data->o_type = $request->input('o_type');
        $data->o_details = $request->input('o_details');
        $data->max_salary = $request->input('max_salary');
        $data->min_salary = $request->input('min_salary');

        $data->intake_cap = $request->input('intake_cap');
        $data->contact = $request->input('contact');

        $data->eligibility = $request->input('eligibility');

        $data->is_active = $request->input('is_active');

        $data->save();
        
        return Redirect(env('tpo').'/openings')->with('message','Opening Updated Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Openings Delete (Trash Data)
    |------------------------------------------------------------------
    */

    public function destroy($id)
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;
        $opening = Openings::findOrFail($id);

        if ( $tpo_id == $opening->tpo_id) {

            $data = Openings::findOrFail($id);
            $data->is_deleted = 1;
            $data->save();

            return Redirect(env('tpo').'/openings')->with('message','Opening Deleted Successfully.');

        }

        return back()->withErros('You do not have access to this!');
    }


    /*
    |------------------------------------------------------------------
    |   List Students Applied for Openings
    |------------------------------------------------------------------
    */

    public function listStudents($id)
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;
        $opening = Openings::findOrFail($id);

        //$openings = Openings::where('tpo_id',$tpo_id)->get();

        $openings_id = $opening->id;

        $op_students = OpeningsStudent::where('openings_id', $openings_id)->get();

        $student = Student::where('is_deleted', 0)->where('status', 0)->get();


         $data = [
            'data' => $op_students,
            'link' => env('tpo').'/openings/',
            'opening' => $opening,
            'student' => $student,
        ];

        return View('tpo.openings.applications',$data);
    }
    

    /*
    |------------------------------------------------------------------
    |   Openings Select For Interview
    |------------------------------------------------------------------
    */

    public function selectForInterview(Request $request, $id)
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;
        $op_students = OpeningsStudent::findOrFail($id);

        $openings_id = $op_students->openings_id;

        $opening = Openings::findOrFail($openings_id);

        if ( $tpo_id == $opening->tpo_id) {

            $data = OpeningsStudent::findOrFail($id);
            $data->selected = 'Yes';
            $data->interviewed = 'Pending';
            $data->hired = 'Pending';
            $data->save();


            $notification = new Notification;
            $notification->student_id = $data->student_id;
            $notification->message = 'Your application for '.$opening->o_type.' has been selected for an Interview';
            $notification->save();


            return Redirect(env('tpo').'/openings/'.$openings_id.'/applications')->with('message','Applicant Selected Successfully.');

        }

        return back()->withErros('You do not have access to this!');
    }


    /*
    |------------------------------------------------------------------
    |   Openings Shedule Interview
    |------------------------------------------------------------------
    */

    public function setupInterview(Request $request, $id)
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;
        $op_students = OpeningsStudent::findOrFail($id);

        $openings_id = $op_students->openings_id;

        $opening = Openings::findOrFail($openings_id);

        if ( $tpo_id == $opening->tpo_id) {

            $data = OpeningsStudent::findOrFail($id);
            $data->selected = 'Yes';          
            $data->interview_date = $request->input('interview_date');
            $data->save();

            $notification = new Notification;
            $notification->student_id = $data->student_id;
            $notification->message = 'Your Interview for '.$opening->o_type.' has been scheduled at '.$request->input('interview_date');
            $notification->save();

            return Redirect(env('tpo').'/openings/'.$openings_id.'/applications')->with('message','Interview Scheduled Successfully.');

        }

        return back()->withErros('You do not have access to this!');
    }



    /*
    |------------------------------------------------------------------
    |   Openings Shedule Interview Page
    |------------------------------------------------------------------
    */

    public function scheduleInterview($id)
    {
        
        $op_students = OpeningsStudent::findOrFail($id);

        $student_id = $op_students->student_id;

        $student = Student::findOrFail($student_id);

        $openings_id = $op_students->openings_id;

        $opening = Openings::findOrFail($openings_id);

         $data = [

            'id' => $id,
            'data' => $op_students,
            //'link' => env('tpo').'/openings/',
            'opening' => $opening,
            'student' => $student,
        ];

        return View('tpo.openings.schedule-interview',$data);
    }


    /*
    |------------------------------------------------------------------
    |   Send Offer Page
    |------------------------------------------------------------------
    */

    public function sendOffer($id)
    {
        
        $op_students = OpeningsStudent::findOrFail($id);

        $student_id = $op_students->student_id;

        $student = Student::findOrFail($student_id);

        $openings_id = $op_students->openings_id;

        $opening = Openings::findOrFail($openings_id);

         $data = [

            'id' => $id,
            'data' => $op_students,
            //'link' => env('tpo').'/openings/',
            'opening' => $opening,
            'student' => $student,

        ];

        return View('tpo.openings.send-offer',$data);
    }



    /*
    |------------------------------------------------------------------
    |   Send Offer Letter
    |------------------------------------------------------------------
    */

   public function sendOfferLetter(Request $request, $id)
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;
        $op_students = OpeningsStudent::findOrFail($id);

        $openings_id = $op_students->openings_id;

        $opening = Openings::findOrFail($openings_id);

        if ( $tpo_id == $opening->tpo_id) {

            $data = OpeningsStudent::findOrFail($id);
            $data->offer = 'Sent';          
            $data->join_date = $request->input('join_date');
            $file_name = time().'.'.request()->file_name->getClientOriginalExtension();

            $data->file_name = $file_name;
            $data->save();

            request()->file_name->move("upload/offer_letters/", $file_name);


            $notification = new Notification;
            $notification->student_id = $data->student_id;
            $notification->message = 'You have received the offer letter for '.$opening->o_type;
            $notification->save();


            return Redirect(env('tpo').'/openings/'.$openings_id.'/applications')->with('message','Offer Sent Successfully.');

        }

        return back()->withErros('You do not have access to this!');
    }

    /*
    |------------------------------------------------------------------
    |   Openings Reject Application
    |------------------------------------------------------------------
    */


    public function rejectApplication($id)
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;
        $op_students = OpeningsStudent::findOrFail($id);

        $openings_id = $op_students->openings_id;

        $opening = Openings::findOrFail($openings_id);

        if ( $tpo_id == $opening->tpo_id) {

            $data = OpeningsStudent::findOrFail($id);
            $data->selected = 'No';
            $data->interviewed = 'No';
            $data->hired = 'No';
            $data->save();

            $notification = new Notification;
            $notification->student_id = $data->student_id;
            $notification->message = 'Your application for '.$opening->o_type.' has been rejected';
            $notification->save();

            return Redirect(env('tpo').'/openings/'.$openings_id.'/applications')->with('message','Application Rejected.');

        }

        return back()->withErros('You do not have access to this!');
    }


    /*
    |------------------------------------------------------------------
    |   Openings Reject Selected Application
    |------------------------------------------------------------------
    */


    public function rejectSelectedApplication($id)
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;
        $op_students = OpeningsStudent::findOrFail($id);

        $openings_id = $op_students->openings_id;

        $opening = Openings::findOrFail($openings_id);

        if ( $tpo_id == $opening->tpo_id) {

            $data = OpeningsStudent::findOrFail($id);

            $data->interviewed = 'No';
            $data->hired = 'No';
            $data->save();


            $notification = new Notification;
            $notification->student_id = $data->student_id;
            $notification->message = 'Your application for '.$opening->o_type.' has been rejected';
            $notification->save();

            return Redirect(env('tpo').'/openings/'.$openings_id.'/applications')->with('message','Application Rejected.');

        }

        return back()->withErros('You do not have access to this!');
    }


    /*
    |------------------------------------------------------------------
    |   Openings Reject Interviewed Application
    |------------------------------------------------------------------
    */


    public function rejectInterviewedApplication($id)
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;
        $op_students = OpeningsStudent::findOrFail($id);

        $openings_id = $op_students->openings_id;

        $opening = Openings::findOrFail($openings_id);

        if ( $tpo_id == $opening->tpo_id) {

            $data = OpeningsStudent::findOrFail($id);
            
            $data->interviewed = 'Yes';
            $data->hired = 'No';
            $data->save();

            $notification = new Notification;
            $notification->student_id = $data->student_id;
            $notification->message = 'Your application for '.$opening->o_type.' has been rejected';
            $notification->save();

            return Redirect(env('tpo').'/openings/'.$openings_id.'/applications')->with('message','Application Rejected.');

        }

        return back()->withErros('You do not have access to this!');
    }


    /*
    |------------------------------------------------------------------
    |   List Selected Applications
    |------------------------------------------------------------------
    */

    public function listSelected($id)
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;
        $opening = Openings::findOrFail($id);

        //$openings = Openings::where('tpo_id',$tpo_id)->get();

        $openings_id = $opening->id;

        $op_students = OpeningsStudent::where('openings_id', $openings_id)->where('selected', 'Yes')->get();

        $student = Student::where('is_deleted', 0)->where('status', 0)->get();


         $data = [
            'data' => $op_students,
            'link' => env('tpo').'/openings/',
            'opening' => $opening,
            'student' => $student,
        ];

        return View('tpo.openings.selected-applications',$data);
    }



    /*
    |------------------------------------------------------------------
    |   List Hired Applicants
    |------------------------------------------------------------------
    */


    public function listHired($id)
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;
        $opening = Openings::findOrFail($id);

        //$openings = Openings::where('tpo_id',$tpo_id)->get();

        $openings_id = $opening->id;

        $op_students = OpeningsStudent::where('openings_id', $openings_id)->where('hired', 'Yes')->get();

        $student = Student::where('is_deleted', 0)->where('status', 0)->get();


         $data = [
            'data' => $op_students,
            'link' => env('tpo').'/openings/',
            'opening' => $opening,
            'student' => $student,
        ];

        return View('tpo.openings.hired-applications',$data);
    }




    /*
    |------------------------------------------------------------------
    |   List Interviewed Applicants
    |------------------------------------------------------------------
    */


    public function listInterviewed($id)
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;
        $opening = Openings::findOrFail($id);

        //$openings = Openings::where('tpo_id',$tpo_id)->get();

        $openings_id = $opening->id;

        $op_students = OpeningsStudent::where('openings_id', $openings_id)->where('interviewed', 'Yes')->get();

        $student = Student::where('is_deleted', 0)->where('status', 0)->get();


         $data = [
            'data' => $op_students,
            'link' => env('tpo').'/openings/',
            'opening' => $opening,
            'student' => $student,
        ];

        return View('tpo.openings.interviewed-applications',$data);
    }



    /*
    |------------------------------------------------------------------
    |   Openings Hire Applicant
    |------------------------------------------------------------------
    */


    public function HireApplicant($id)
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;
        $op_students = OpeningsStudent::findOrFail($id);

        $openings_id = $op_students->openings_id;

        $opening = Openings::findOrFail($openings_id);

        if ( $tpo_id == $opening->tpo_id) {

            $data = OpeningsStudent::findOrFail($id);
            $data->hired = 'Yes';
            $data->save();

            $notification = new Notification;
            $notification->student_id = $data->student_id;
            $notification->message = 'You have been hired for '.$opening->o_type;
            $notification->save();

            return Redirect(env('tpo').'/openings/'.$openings_id.'/applications/interviewed')->with('message','Applicant Hired Successfully.');

        }

        return back()->withErros('You do not have access to this!');
    }



    /*
    |------------------------------------------------------------------
    |   Openings Mark Interviewed
    |------------------------------------------------------------------
    */


    public function markInterviewed($id)
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;
        $op_students = OpeningsStudent::findOrFail($id);

        $openings_id = $op_students->openings_id;

        $opening = Openings::findOrFail($openings_id);

        if ( $tpo_id == $opening->tpo_id) {

            $data = OpeningsStudent::findOrFail($id);
            $data->interviewed = 'Yes';
            $data->save();


            $notification = new Notification;
            $notification->student_id = $data->student_id;
            $notification->message = 'You have been marked interviewed for '.$opening->o_type;
            $notification->save();

            return Redirect(env('tpo').'/openings/'.$openings_id.'/applications/selected')->with('message','Applicant Marked Interviewed.');

        }

        return back()->withErros('You do not have access to this!');
    }


    /*
    |------------------------------------------------------------------
    |   List Placement Report
    |------------------------------------------------------------------
    */

    public function ReportsPage()
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;

        $op_students = OpeningsStudent::get();
        
        $data = [
            'data' => Openings::where('tpo_id', $tpo_id)->where('is_deleted', 0)->get(),
            'link' => env('tpo').'/placement-reports/',
            'op_students' => $op_students
        ];

        return View('tpo.openings.reports',$data);
    }


    /*
    |------------------------------------------------------------------
    |   Placement Report Single
    |------------------------------------------------------------------
    */


    public function ReportSingle($id)
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;
        $opening = Openings::findOrFail($id);


        $openings_id = $opening->id;

    

        $application_count = OpeningsStudent::where('openings_id', $openings_id)->count();
        $interviewed_count = OpeningsStudent::where('openings_id', $openings_id)->where('interviewed','Yes')->count();
        $selected_count = OpeningsStudent::where('openings_id', $openings_id)->where('selected','Yes')->count();
        $hired_count = OpeningsStudent::where('openings_id', $openings_id)->where('hired','Yes')->count();



         $data = [
            'id' => $id,
            'application_count' => $application_count,
            'interviewed_count' => $interviewed_count,
            'selected_count' => $selected_count,
            'hired_count' => $hired_count,
            'rejected_count' => $application_count - $hired_count,
            'link' => env('tpo').'/placement-reports/',
            'opening' => $opening,
        ];

        return View('tpo.openings.report-single',$data);
    }


    /*
    |------------------------------------------------------------------
    |   Detailed Placement Report
    |------------------------------------------------------------------
    */

    public function listReport($id)
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;
        $opening = Openings::findOrFail($id);

        //$openings = Openings::where('tpo_id',$tpo_id)->get();

        $openings_id = $opening->id;

        $op_students = OpeningsStudent::where('openings_id', $openings_id)->get();

        $student = Student::where('is_deleted', 0)->where('status', 0)->get();


         $data = [
            'data' => $op_students,
            'link' => env('tpo').'/placement-reports/',
            'opening' => $opening,
            'student' => $student,
        ];

        return View('tpo.openings.detailed-report',$data);
    }



     /*
    |------------------------------------------------------------------
    |   Download CV
    |------------------------------------------------------------------
    */
    public function downloadCV($id)
    {

            $op_students = OpeningsStudent::findOrFail($id);

            $file_path = 'upload/student_cv/'. $op_students->cv_file;

            if($op_students->cv_file == null) {

                return back()->with('error','No File Found.');



            }
            return Response::download($file_path);

    }

}
