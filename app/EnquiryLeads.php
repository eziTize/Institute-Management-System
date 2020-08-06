<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Excel;
use Auth;
use App\EnquiryLeadsComments;
use Carbon\Carbon;

class EnquiryLeads extends Model
{
    protected $table = "enquiry_leads";

    /*
    |----------------------------------------------------------------
    |   Validation rules
    |----------------------------------------------------------------
    */
    public $rules = array(
        'student_name'      => 'max:255',
        'phone'             => 'required|numeric',
        'enquiry_src'       => 'required',
        'course'            => 'required'
    );

    public $erules = array(
        'student_name'      => 'max:255',
        'phone'             => 'required|numeric',
        'enquiry_src'       => 'required',
        'course'            => 'required'
    );

    public $crules = array(
        'type'              => 'required',
        'lead_quality'      => 'required',
        'comments'          => 'required'
    );

    public $wrules = array(
        'student_name'      => 'required',
        'id_photo'          => 'required',
        'course'            => 'required'
    );

    /*
    |----------------------------------------------------------------
    |   Validate data for add & update records
    |----------------------------------------------------------------
    */
    public function validate($data,$type){
        if($type == "edit"){
            $ruleType = $this->erules;
        }elseif($type == "add"){
            $ruleType = $this->rules;
        }elseif($type == "comment"){
            $ruleType = $this->crules;
        }elseif($type == "walk_in"){
            $ruleType = $this->wrules;
        }else{
            $ruleType = $this->arules;
        }

        $validator = Validator::make($data,$ruleType);

        if($validator->fails()){
            return $validator;
        }
    }
    
    /*
    |------------------------------------------------------------------
    |   If duplicate Phone entered 
    |------------------------------------------------------------------
    */
    public function duplicateChk($type,$request,$id=0){
        $phone = $request->get('phone');

        if($type == "add"){
            if(EnquiryLeads::where('phone',$phone)->exists()){
                return "Phone";
            }else{
                return false;
            }
        }else{
            if(EnquiryLeads::where('id','!=',$id)->where('phone',$phone)->exists()){
                return "Phone";
            }else{
                return false;
            }
        }
    }

    /*
    |-------------------------------------
    |   Upload Excel File
    |--------------------------------------
    */
    public function uploadExcel($file){
        $marketing_person_id = Auth::guard('marketing_person')->user()->id;

        $path  = $file->getRealPath();
        $excel = Excel::load($path, function($reader){})->get();

        if(!empty($excel) && $excel->count()){
            $i = 1;
            $c = 0;
            foreach($excel as $exl){
                if($i>1000){
                    break;
                }

                if($exl->phone_number && $exl->enquiry_source){
                    $data = new EnquiryLeads;

                    $excl = [];
                    $excl['student_name'] = $exl->student_name;
                    $excl['phone'] = $exl->phone_number;
                    $excl['enquiry_src'] = $exl->enquiry_source;
                    $excl['course'] = $exl->course;

                    if(!$data->validate($excl,"add")){
                        $enquiry_src_arr = explode(':',$excl['enquiry_src']);
                        $course_arr = explode(':',$excl['course']);

                        if(EnquirySrc::where('id',$enquiry_src_arr[0])->where('status','0')->where('is_deleted','0')->exists() && Course::where('id',$course_arr[0])->where('status','0')->where('is_deleted','0')->exists()){
                            $data->student_name = $excl['student_name'];
                            $data->phone = $excl['phone'];
                            $data->enquiry_src = $enquiry_src_arr[0];
                            $data->course = $course_arr[0];
                            $data->added_by = $marketing_person_id;
                            $data->save();

                            $c++;
                        }
                    }

                    $i++;
                }
            }

            return $c;
        }else{
            return -1;
        }
    }
    
    /*
    |------------------------------------------------------------------
    |   Get All Comments of Single Enquiry
    |------------------------------------------------------------------
    */
    public function getAllComments($enq_id){
        return EnquiryLeadsComments::where('enquiry_leads_id', $enq_id)->get();
    }

    /*
    |------------------------------------------------------------------
    |   Get All Enquiry With Respect To Status and Search Result
    |------------------------------------------------------------------
    */
    public static function getAllEnquiry($type,$status=''){
        if($type == 'marketing_person'){
            $marketing_person_id = Auth::guard($type)->user()->id;        

            return EnquiryLeads::where('added_by',$marketing_person_id)->where('is_deleted','0')->where(function($query){
                if(isset($_GET['phone']) && $_GET['phone'] != ''){
                    $query->where('phone','like','%'.$_GET['phone'].'%');
                }
                if(isset($_GET['enquiry_src']) && $_GET['enquiry_src'] != ''){
                    $query->where('enquiry_src',$_GET['enquiry_src']);
                }
                if(isset($_GET['course']) && $_GET['course'] != ''){
                    $query->where('course',$_GET['course']);
                }
                if(isset($_GET['status']) && $_GET['status'] != ''){
                    $query->where('status',$_GET['status']);
                }
            })->orderby('id','desc')->get();
        }elseif($type == 'admin' || $type == 'branch'){
            return EnquiryLeads::where('is_deleted','0')->where(function($query){
                if(isset($_GET['phone']) && $_GET['phone'] != ''){
                    $query->where('phone','like','%'.$_GET['phone'].'%');
                }
                if(isset($_GET['enquiry_src']) && $_GET['enquiry_src'] != ''){
                    $query->where('enquiry_src',$_GET['enquiry_src']);
                }
                if(isset($_GET['course']) && $_GET['course'] != ''){
                    $query->where('course',$_GET['course']);
                }
                if(isset($_GET['status']) && $_GET['status'] != ''){
                    $query->where('status',$_GET['status']);
                }
            })->orderby('id','desc')->get();
        }elseif($type == 'telecaller'){
            $telecaller_id = Auth::guard($type)->user()->id;

            return EnquiryLeads::where('assigned_to',$telecaller_id)->where('status',$status)->where('is_deleted','0')->where(function($query){
                if(isset($_GET['phone']) && $_GET['phone'] != ''){
                    $query->where('phone','like','%'.$_GET['phone'].'%');
                }
                if(isset($_GET['enquiry_src']) && $_GET['enquiry_src'] != ''){
                    $query->where('enquiry_src',$_GET['enquiry_src']);
                }
                if(isset($_GET['course']) && $_GET['course'] != ''){
                    $query->where('course',$_GET['course']);
                }
            })->orderby('id','desc')->get();
        }
    }

    public static function getNotReplied24HrsEnquiry(){
        return EnquiryLeads::where('assigned_date', '<', Carbon::now()->subDay())->where('status','1')->where('is_deleted','0')->where(function($query){
            if(isset($_GET['phone']) && $_GET['phone'] != ''){
                $query->where('phone','like','%'.$_GET['phone'].'%');
            }
            if(isset($_GET['enquiry_src']) && $_GET['enquiry_src'] != ''){
                $query->where('enquiry_src',$_GET['enquiry_src']);
            }
            if(isset($_GET['course']) && $_GET['course'] != ''){
                $query->where('course',$_GET['course']);
            }
        })->orderby('id','desc')->get();
    }

    /*
    |------------------------------------------------------------------
    |   Photo Upload for Student ID
    |------------------------------------------------------------------
    */
    public static function addNew($data){
        if($data['id_photo']){
            $add = EnquiryLeads::find($data['id']);

            $filename  = $add->phone.'.jpg';
            $data['id_photo']->move("upload/walkin/", $filename);
            $add->id_photo = $filename;
            $add->save();

            return true;
        }

        return false;
    }
}