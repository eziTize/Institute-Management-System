<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;


class Fees extends Model
{
    //
     protected $table = "fees"; 

	/*
	|----------------------------------------------------------------
	|	Validation rules
	|----------------------------------------------------------------
	*/
	public $rules = array(

            'student_id' => 'required',
            'fee' => 'required|numeric',
            'description' => 'required|max:255',
            'fee_date' => 'required|date|date_format:d-m-Y',
   );

    /*
	|----------------------------------------------------------------
	|	Validate data for adding records
	|----------------------------------------------------------------
	*/
    public function validate($data){
        
            $ruleType = $this->rules;

       $validator = Validator::make($data, $ruleType);

       if($validator->fails()){
            return $validator;
       }
	}
}
