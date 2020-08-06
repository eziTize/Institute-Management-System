<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Course extends Model
{
    protected $table = "course";

	/*
	|----------------------------------------------------------------
	|	Validation rules
	|----------------------------------------------------------------
	*/
	public $rules = array(
		'name' 		    	=> 'required|max:255',
        'duration' 	    	=> 'required|numeric'
    );

    public $erules = array(
        'name' 		    	=> 'required|max:255',
        'duration' 	    	=> 'required|numeric'
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
			if(Course::where('name',$name)->exists()){
				return "Course Name";
			}else{
				return false;
			}
		}else{
            if(Course::where('id','!=',$id)->where('name',$name)->exists()){
				return "Course Name";
			}else{
				return false;
			}
		}
	}
}
