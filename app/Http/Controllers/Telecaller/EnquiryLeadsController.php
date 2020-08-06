<?php



namespace App\Http\Controllers\Telecaller;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\EnquiryLeads;

use App\EnquirySrc;

use App\LeadQuality;

use App\EnquiryLeadsComments;

use App\Course;

use Auth;

use Carbon\Carbon;



class EnquiryLeadsController extends Controller

{

    /*

    |------------------------------------------------------------------

    |   Open Enquiry Leads List Page

    |------------------------------------------------------------------

    */

    public function assigned(){

        $telecaller_id = Auth::guard('telecaller')->user()->id;



        $data = [

            'data' => EnquiryLeads::getAllEnquiry('telecaller','1'),

            'enquiry_src' => EnquirySrc::where('status','0')->where('is_deleted','0')->get(),

            'course' => Course::where('status','0')->where('is_deleted','0')->get(),

            'single_enquiry_src' => new EnquirySrc,

            'single_course' => new Course,

            'lead_quality' => LeadQuality::get(),

            'type' => 'assigned',

            'link' => env('telecaller').'/enquiry_leads_assigned'

        ];



        return View('telecaller.enquiry_leads.index',$data);

    }



    /*

    |------------------------------------------------------------------

    |   Called Enquiry Leads List Page

    |------------------------------------------------------------------

    */

    public function called(){

        $telecaller_id = Auth::guard('telecaller')->user()->id;



        $data = [

            'data' => EnquiryLeads::getAllEnquiry('telecaller','2'),

            'enquiry_src' => EnquirySrc::where('status','0')->where('is_deleted','0')->get(),

            'course' => Course::where('status','0')->where('is_deleted','0')->get(),

            'single_enquiry_src' => new EnquirySrc,

            'single_course' => new Course,

            'lead_quality' => LeadQuality::get(),

            'single_lead_quality' => new LeadQuality,

            'type' => 'called',

            'link' => env('telecaller').'/enquiry_leads_called'

        ];



        return View('telecaller.enquiry_leads.index',$data);

    }



    /*

    |------------------------------------------------------------------

    |   Walked In Enquiry Leads List Page

    |------------------------------------------------------------------

    */

    public function walked_in(){

        $telecaller_id = Auth::guard('telecaller')->user()->id;

        

        $data = [

            'data' => EnquiryLeads::getAllEnquiry('telecaller','3'),

            'enquiry_src' => EnquirySrc::where('status','0')->where('is_deleted','0')->get(),

            'course' => Course::where('status','0')->where('is_deleted','0')->get(),

            'single_enquiry_src' => new EnquirySrc,

            'single_course' => new Course,

            'lead_quality' => LeadQuality::get(),

            'single_lead_quality' => new LeadQuality,

            'type' => 'walked_in',

            'link' => env('telecaller').'/enquiry_leads_walked_in'

        ];



        return View('telecaller.enquiry_leads.index',$data);

    }



    /*

    |------------------------------------------------------------------

    |   Admitted Enquiry Leads List Page

    |------------------------------------------------------------------

    */

    public function admitted(){

        $telecaller_id = Auth::guard('telecaller')->user()->id;

        

        $data = [

            'data' => EnquiryLeads::getAllEnquiry('telecaller','4'),

            'enquiry_src' => EnquirySrc::where('status','0')->where('is_deleted','0')->get(),

            'course' => Course::where('status','0')->where('is_deleted','0')->get(),

            'single_enquiry_src' => new EnquirySrc,

            'single_course' => new Course,

            'lead_quality' => LeadQuality::get(),

            'single_lead_quality' => new LeadQuality,

            'type' => 'admitted',

            'link' => env('telecaller').'/enquiry_leads_admitted'

        ];



        return View('telecaller.enquiry_leads.index',$data);

    }



    /*

    |------------------------------------------------------------------

    |   Enquiry Leads Feedback Post

    |------------------------------------------------------------------

    */

    public function feedback(Request $request,$id){

        $telecaller_id = Auth::guard('telecaller')->user()->id;



        $data = EnquiryLeads::find($id);



        if($data->validate($request->all(),"comment")){

            return Redirect(env('telecaller').'/enquiry_leads_'.$request->get('type'))->withErrors($data->validate($request->all(),"comment"))->withInput();

        }



        $data->student_name = $request->get('student_name');

        $data->course = $request->get('course');

        $data->lead_quality = $request->get('lead_quality');

        if($request->get('type') == 'assigned'){

            $data->status = 2;

        }

        $data->save();



        $data1 = new EnquiryLeadsComments;

        $data1->enquiry_leads_id = $id;

        $data1->comments = $request->get('comments');

        $data1->save();



        return Redirect(env('telecaller').'/enquiry_leads_'.$request->get('type'))->with('message','Feedback Added Successfully.');

    }



    /*

    |------------------------------------------------------------------

    |   Enquiry Leads Make Walk In

    |------------------------------------------------------------------

    */

    public function make_walk_in(Request $request,$id){

        $data = EnquiryLeads::find($id);



        if($data->validate($request->all(),"walk_in")){

            return Redirect(env('telecaller').'/enquiry_leads_called')->withErrors($data->validate($request->all(),"walk_in"))->withInput();

        }





        $upload = EnquiryLeads::addNew([

            'id' => $data->id,

            'id_photo' => $request->file('id_photo')

        ]);



        if($upload){

            $data->student_name = $request->get('student_name');

            $data->course = $request->get('course');

            $data->status = 3;

            $data->save();



            return Redirect(env('telecaller').'/enquiry_leads_called')->with('message','Walked In Successfully');

        }else{

            return Redirect(env('telecaller').'/enquiry_leads_called')->with('error','Sorry! Photo Upload Failed')->withInput();

        }

    }



    /*

    |------------------------------------------------------------------

    |   Enquiry Leads Make Admission

    |------------------------------------------------------------------

    */

    public function make_admission(Request $request,$id){



    }

}

