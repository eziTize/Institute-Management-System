<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;


class AdFees extends Model
{
    //
     protected $table = "ad_fees"; 

	/*
	|----------------------------------------------------------------
	|	Validation rules
	|----------------------------------------------------------------
	*/
	public $rules = array(

            'student_id' => 'required',
            'batch_id' => 'required',
            'admission_fee' => 'required|numeric',
            'ppts_fee' => 'numeric',
            'reg_fee' => 'required|numeric',
            'sq_deposit' => 'numeric',
            'discount' => 'numeric',
            'start_date' => 'required|date|date_format:d-m-Y',
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
