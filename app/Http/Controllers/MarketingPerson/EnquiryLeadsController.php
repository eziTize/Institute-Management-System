<?php

namespace App\Http\Controllers\MarketingPerson;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EnquiryLeads;
use App\EnquirySrc;
use App\LeadQuality;
use App\Course;
use Excel;
use Auth;

class EnquiryLeadsController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Enquiry Leads List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $data = [
            'data' => EnquiryLeads::getAllEnquiry('marketing_person'),
            'enquiry_src' => EnquirySrc::where('status','0')->where('is_deleted','0')->get(),
            'course' => Course::where('status','0')->where('is_deleted','0')->get(),
            'single_enquiry_src' => new EnquirySrc,
            'single_course' => new Course,
            'lead_quality' => LeadQuality::get(),
            'link' => env('marketing_person').'/enquiry_leads/'
        ];

        return View('marketing_person.enquiry_leads.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Download Demo Excel Format of Enquiry Leads
    |------------------------------------------------------------------
    */
    public function excel_format_download(){
        Excel::create('enquiry_leads-'.time(), function($excel){
            $excel->sheet('bulk_upload', function($sheet){
                
                $sheet->SetCellValue("A1", "Student Name");
                $sheet->SetCellValue("B1", "Phone Number");
                $sheet->SetCellValue("C1", "Enquiry Source");
                $sheet->SetCellValue("D1", "Course");

                $sheet->getProtection()->setSheet(true);
                $sheet->getStyle('A2:D1001')->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

                $enq_src = EnquirySrc::where('status','0')->where('is_deleted','0')->get();
                $crses = Course::where('status','0')->where('is_deleted','0')->get();

                $enquiry_src = "";
                foreach($enq_src as $enq){
                    if($enquiry_src != ""){
                        $enquiry_src .= ",";
                    }
                    $enquiry_src .= $enq->id.":".$enq->name;
                }

                $course = "";
                foreach($crses as $crs){
                    if($course != ""){
                        $course .= ",";
                    }
                    $course .= $crs->id.":".$crs->name;
                }

                for($i=2; $i<=1001; $i++){//FORMAT_NUMBER
                    $sheet->getStyle('A'.$i)->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                    $sheet->getStyle('B'.$i)->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);

                    $enquiry_src_objValidation = $sheet->getCell('C'.$i)->getDataValidation();
                    $enquiry_src_objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $enquiry_src_objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_STOP);
                    $enquiry_src_objValidation->setAllowBlank(true);
                    $enquiry_src_objValidation->setShowInputMessage(true);
                    $enquiry_src_objValidation->setShowErrorMessage(true);
                    $enquiry_src_objValidation->setShowDropDown(true);
                    $enquiry_src_objValidation->setErrorTitle('Enquiry Source error');
                    $enquiry_src_objValidation->setError('Enquiry Source is not on the list');
                    $enquiry_src_objValidation->setFormula1('"'.$enquiry_src.'"');

                    $course_objValidation = $sheet->getCell('D'.$i)->getDataValidation();
                    $course_objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $course_objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_STOP);
                    $course_objValidation->setAllowBlank(true);
                    $course_objValidation->setShowInputMessage(true);
                    $course_objValidation->setShowErrorMessage(true);
                    $course_objValidation->setShowDropDown(true);
                    $course_objValidation->setErrorTitle('Course error');
                    $course_objValidation->setError('Course is not on the list');
                    $course_objValidation->setFormula1('"'.$course.'"');
                }
            });
        })->download('xlsx');
    }

    /*
    |------------------------------------------------------------------
    |   Bulk Upload Enquiry Leads
    |------------------------------------------------------------------
    */
    public function bulk_upload(Request $request){
        $data = new EnquiryLeads;

        $bulk_up = $data->uploadExcel($request->file('bulk_file'));

        if($bulk_up > 0){
            return Redirect(env('marketing_person').'/enquiry_leads')->with('message',$bulk_up.' Enquiry Leads Bulk Added Successfully.');
        }elseif($bulk_up == 0){
            return Redirect(env('marketing_person').'/enquiry_leads')->with('error','Sorry! No Enquiry Leads Bulk Added.')->withInput();
        }else{
            return Redirect(env('marketing_person').'/enquiry_leads')->with('error','Sorry! Excel File is Empty.')->withInput();
        }
    }

    /*
    |------------------------------------------------------------------
    |   Enquiry Leads Add Page
    |------------------------------------------------------------------
    */
    public function show(){
        $data = [
            'data' => new EnquiryLeads,
            'enquiry_src' => EnquirySrc::where('status','0')->where('is_deleted','0')->pluck('name','id'),
            'course' => Course::where('status','0')->where('is_deleted','0')->pluck('name','id'),
            'link' => env('marketing_person').'/enquiry_leads/'
        ];

        return View('marketing_person.enquiry_leads.add',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Enquiry Leads Data Store
    |------------------------------------------------------------------
    */
    public function store(Request $request){
        $marketing_person_id = Auth::guard('marketing_person')->user()->id;

        $data = new EnquiryLeads;

        if($data->validate($request->all(),"add")){
            return Redirect(env('marketing_person').'/enquiry_leads/add')->withErrors($data->validate($request->all(),"add"))->withInput();
        }elseif($data->duplicateChk("add",$request)){
            return Redirect(env('marketing_person').'/enquiry_leads/add')->with('error','Sorry! '.$data->duplicateChk("add",$request).' Already Exists')->withInput();
        }

        $data->student_name = $request->get('student_name');
        $data->phone = $request->get('phone');
        $data->enquiry_src = $request->get('enquiry_src');
        $data->course = $request->get('course');
        $data->added_by = $marketing_person_id;
        $data->save();

        return Redirect(env('marketing_person').'/enquiry_leads')->with('message','New Enquiry Lead Added Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Edit Enquiry Leads Page
    |------------------------------------------------------------------
    */
    public function edit($id){
        $data = [
            'id' => $id,
            'data' => EnquiryLeads::find($id),
            'course' => Course::where('status','0')->where('is_deleted','0')->pluck('name','id'),
            'enquiry_src' => EnquirySrc::where('status','0')->where('is_deleted','0')->pluck('name','id'),
            'link' => env('marketing_person').'/enquiry_leads/'
        ];

        return View('marketing_person.enquiry_leads.edit',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Enquiry Leads Data Update
    |------------------------------------------------------------------
    */
    public function update(Request $request,$id){
        $data = EnquiryLeads::find($id);

        if($data->validate($request->all(),"edit")){
            return Redirect(env('marketing_person').'/enquiry_leads/'.$id.'/edit')->withErrors($data->validate($request->all(),"edit"))->withInput();
        }elseif($data->duplicateChk("edit",$request,$id)){
            return Redirect(env('marketing_person').'/enquiry_leads/'.$id.'/edit')->with('error','Sorry! '.$data->duplicateChk("edit",$request,$id).' Already Exists')->withInput();
        }

        $data->phone = $request->get('phone');
        $data->enquiry_src = $request->get('enquiry_src');
        $data->course = $request->get('course');

        $data->save();

        return Redirect(env('marketing_person').'/enquiry_leads')->with('message','Enquiry Lead Updated Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Enquiry Leads Data Delete
    |------------------------------------------------------------------
    */
    public function destroy($id){
        EnquiryLeads::where('id', $id)->delete();

        return Redirect(env('marketing_person').'/enquiry_leads')->with('message','Enquiry Lead Deleted Successfully.');
    }
}
