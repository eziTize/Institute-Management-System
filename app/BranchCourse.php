<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use DB;

class BranchCourse extends Model
{
	protected $table = "branch_course";
	
	protected $guarded = ['id'];

	/*
	|----------------------------------------------------------------
	|	Validation rules
	|----------------------------------------------------------------
	*/
	public $rules = array(
		'course_id' 	=> 'required|array|min:1',
		'course_id.*'	=> 'required',
		'fee' 	    	=> 'required|array|min:1',
		'fee.*'			=> 'numeric|nullable'
    );

    /*
	|----------------------------------------------------------------
	|	Validate data for add & update records
	|----------------------------------------------------------------
	*/
    public function validate($data){
        $validator = Validator::make($data,$this->rules);

        if($validator->fails()){
            return $validator;
        }
	}

	/*
	|----------------------------------------------------------------
	|	Single Course View
	|----------------------------------------------------------------
	*/
	public static function courseView($branch_id,$course_id){
		$course = DB::table('branch_course')
					->join('course', 'course.id', '=','branch_course.course_id')
					->select('branch_course.*', 'course.name', 'course.duration')
					->where('branch_course.branch_id', $branch_id)
					->where('branch_course.course_id', $course_id)
					->where('branch_course.fee', '>' , '0')
					->where('branch_course.status', 'Y')
					->first();
					
		return $course;
    }
}
