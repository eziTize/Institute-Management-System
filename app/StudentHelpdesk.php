<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class StudentHelpdesk extends Model
{
	protected $table = "student_helpdesk";

	/*
	|----------------------------------------------------------------
	|	Validation rules
	|----------------------------------------------------------------
	*/
	public $rules = array(
        'student_id' 	=> 'required',
        'type' 		    => 'required',
        'title' 		=> 'required|max:255',
        'description'	=> 'required'
	);
	
	public $erules = array(
        'title' 		=> 'required|max:255',
        'description'	=> 'required'
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
}
