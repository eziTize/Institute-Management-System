<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EnquiryLeads;
use App\EnquirySrc;
use App\LeadQuality;
use App\Course;
use App\Telecaller;
use Excel;
use Carbon\Carbon;

class EnquiryLeadsController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Enquiry Leads List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $data = [
            'data' => EnquiryLeads::getAllEnquiry('admin'),
            'enquiry_src' => EnquirySrc::where('status','0')->where('is_deleted','0')->get(),
            'course' => Course::where('status','0')->where('is_deleted','0')->get(),
            'single_enquiry_src' => new EnquirySrc,
            'single_course' => new Course,
            'lead_quality' => LeadQuality::get(),
            'telecaller' => Telecaller::where('status','0')->where('is_deleted','0')->get(),
            'link' => env('admin').'/enquiry_leads/'
        ];

        return View('admin.enquiry_leads.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Not Replied within 24 Hours Enquiry Leads List Page
    |------------------------------------------------------------------
    */
    public function not_replied(){
        $data = [
            'data' => EnquiryLeads::getNotReplied24HrsEnquiry(),
            'enquiry_src' => EnquirySrc::where('status','0')->where('is_deleted','0')->get(),
            'course' => Course::where('status','0')->where('is_deleted','0')->get(),
            'single_enquiry_src' => new EnquirySrc,
            'single_course' => new Course,
            'lead_quality' => LeadQuality::get(),
            'telecaller' => Telecaller::where('status','0')->where('is_deleted','0')->get(),
            'link' => env('admin').'/enquiry_leads/'
        ];

        return View('admin.enquiry_leads.not_replied',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Enquiry Leads Added to Telecaller
    |------------------------------------------------------------------
    */
    public function assign(Request $request,$id){
        $data = EnquiryLeads::find($id);

        if($data->assigned_to != $request->get('assigned_to')){
            $data->assigned_to = $request->get('assigned_to');
            $data->assigned_date = Carbon::now();
            if($data->status == 0){
                $data->status = 1;
            }
            $data->save();
        }

        return Redirect(env('admin').'/enquiry_leads')->with('message','Enquiry Lead Assigned Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Edit Enquiry Leads Page
    |------------------------------------------------------------------
    */
    public function edit($id){
        $enquiry_leads = EnquiryLeads::find($id);

        if($enquiry_leads->status > 1){
            return Redirect(env('admin').'/enquiry_leads')->with('error','Sorry! Already Called Number cannot be Edited');
        }

        $data = [
            'id' => $id,
            'data' => EnquiryLeads::find($id),
            'enquiry_src' => EnquirySrc::where('status','0')->where('is_deleted','0')->pluck('name','id'),
            'course' => Course::where('status','0')->where('is_deleted','0')->pluck('name','id'),
            'link' => env('admin').'/enquiry_leads/'
        ];

        return View('admin.enquiry_leads.edit',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Enquiry Leads Data Update
    |------------------------------------------------------------------
    */
    public function update(Request $request,$id){
        $data = EnquiryLeads::find($id);

        if($data->validate($request->all(),"edit")){
            return Redirect(env('admin').'/enquiry_leads/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }elseif($data->duplicateChk("edit",$request,$id)){
            return Redirect(env('admin').'/enquiry_leads/'.$id.'/edit')->with('error','Sorry! '.$data->duplicateChk("edit",$request,$id).' Already Exists')->withInput();
        }

        $data->student_name = $request->get('student_name');
        $data->phone = $request->get('phone');
        $data->enquiry_src = $request->get('enquiry_src');
        $data->course = $request->get('course');
        $data->save();

        return Redirect(env('admin').'/enquiry_leads')->with('message','Enquiry Lead Updated Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Enquiry Leads Data Delete
    |------------------------------------------------------------------
    */
    public function destroy($id){
        $enquiry_leads = EnquiryLeads::find($id);

        if($enquiry_leads->status > 1){
            return Redirect(env('admin').'/enquiry_leads')->with('error','Sorry! Already Called Number cannot be Deleted');
        }

        EnquiryLeads::where('id', $id)->delete();

        return Redirect(env('admin').'/enquiry_leads')->with('message','Enquiry Lead Deleted Successfully.');
    }
}
