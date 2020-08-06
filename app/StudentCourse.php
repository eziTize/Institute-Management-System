<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class StudentCourse extends Model
{
    protected $table = "student_course";

	/*
	|----------------------------------------------------------------
	|	Validation rules
	|----------------------------------------------------------------
	*/
	public $rules = array(
		'batch'				=> 'required',
		'course_join'		=> 'required|date',
		'course_complete'	=> 'required|date'
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
}