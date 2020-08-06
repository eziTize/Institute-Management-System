<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use DB;

class Batch extends Model
{
	protected $table = "batch";

	/*
	|----------------------------------------------------------------
	|	Validation rules
	|----------------------------------------------------------------
	*/
	public $rules = array(
        'branch_course' => 'required',
        'name' 		    => 'required|max:255'
	);
	
	public $erules = array(
        'name' 		    => 'required|max:255'
    );

    /*
	|----------------------------------------------------------------
	|	Validate data for add & update records
	|----------------------------------------------------------------
	*/
    public function validate($data,$type){
		if($type == "edit"){
            $ruleType = $this->erules;
        }else{
            $ruleType = $this->rules;
        }
		
		$validator = Validator::make($data,$ruleType);

        if($validator->fails()){
            return $validator;
        }
	}
	
	/*
	|------------------------------------------------------------------
	|	If duplicate Name entered 
	|------------------------------------------------------------------
	*/
	public function duplicateChk($type,$request,$id=0){
		$name = strtolower($request->get('name'));

		if($type == "add"){
			if(Batch::where('name',$name)->exists()){
				return "Batch Name";
			}else{
				return false;
			}
		}else{
            if(Batch::where('id','!=',$id)->where('name',$name)->exists()){
				return "Batch Name";
			}else{
				return false;
			}
		}
	}

	/*
	|----------------------------------------------------------------
	|	Single Batch View
	|----------------------------------------------------------------
	*/
	public static function batchView($id){
		$course = DB::table('batch')
					->join('branch_course', 'branch_course.id', '=','batch.branch_course_id')
					->join('branch', 'branch.id', '=','branch_course.branch_id')
					->join('course', 'course.id', '=','branch_course.course_id')
					->select('batch.*', 'branch.name as branch_name', 'course.name as course_name', 'branch_course.fee')
					->where('batch.id', $id)
					->where('branch_course.fee', '>' , '0')
					->where('branch_course.status', 'Y')
					->first();
					
		return $course;
    }

	/*
	|----------------------------------------------------------------
	|	Single Batch View in Branch
	|----------------------------------------------------------------
	*/
	public static function branchBatchView($branch_id,$id){
		$course = DB::table('batch')
					->join('branch_course', 'branch_course.id', '=','batch.branch_course_id')
					->join('branch', 'branch.id', '=','branch_course.branch_id')
					->join('course', 'course.id', '=','branch_course.course_id')
					->select('batch.*', 'branch.name as branch_name', 'course.name as course_name', 'branch_course.fee')
					->where('batch.id', $id)
					->where('branch.id', $branch_id)
					->where('branch_course.fee', '>' , '0')
					->where('branch_course.status', 'Y')
					->first();
					
		return $course;
    }
}
