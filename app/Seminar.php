<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
use Auth;

class Seminar extends Authenticatable
{
    protected $table = "seminars";

	/*
	|----------------------------------------------------------------
	|	Validation rules
	|----------------------------------------------------------------
	*/
	public $rules = array(
		'sm_name' 			=> 'required|max:255',
		'date'				=> 'date',
		't_plan'			=> 'required|max:255',
		'remarks'			=> 'max:255',
		'ph_no'				=> 'numeric',
		'expense'			=> 'numeric',
		'budget'			=> 'required|numeric',
		

    );

    public $erules = array(
		'sm_name' 			=> 'required|max:255',
		'date'				=> 	'date',
		't_plan'			=> 'required|max:255',
		'remarks'			=> 'max:255',
		'ph_no'				=> 'numeric',
		'expense'			=> 'numeric',
		'budget'			=> 'required|numeric',
		
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
