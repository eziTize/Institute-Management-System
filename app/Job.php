<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Job extends Model
{
	protected $table = "job";

	/*
	|----------------------------------------------------------------
	|	Validation rules
	|----------------------------------------------------------------
	*/
	public $rules = array(
        'job_desc'		=> 'required',
        'start_date'	=> 'required|date',
        'end_date'		=> 'required|date'
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
