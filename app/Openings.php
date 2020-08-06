<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
use Auth;

class Openings extends Authenticatable
{
    protected $table = "openings";

	/*
	|----------------------------------------------------------------
	|	Validation rules
	|----------------------------------------------------------------
	*/
	public $rules = array(

		'company_name' 		=> 'required|max:255',
		'date'				=> 'date',
		'company_details'	=> 'max:255',
		'o_type'			=> 'required|max:255',
		'o_details'			=> 'max:255',
		'eligibility'		=> 'required|max:255',
		'contact'			=> 'numeric',
		'max_salary'		=> 'numeric',
		'min_salary'		=> 'numeric',
		'intake_cap'		=> 'numeric',
		

    );

    public $erules = array(
    	
		'company_name' 		=> 'required|max:255',
		'date'				=> 'date',
		'company_details'	=> 'max:255',
		'o_type'			=> 'required|max:255',
		'o_details'			=> 'max:255',
		'eligibility'		=> 'required|max:255',
		'contact'			=> 'numeric',
		'max_salary'		=> 'numeric',
		'min_salary'		=> 'numeric',
		'intake_cap'		=> 'numeric',
		
    );

    /*
	|----------------------------------------------------------------
	|	Validate data for add & update records
	|----------------------------------------------------------------
	*/
    public function validate($data, $type){
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

