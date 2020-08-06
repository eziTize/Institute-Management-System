<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Task extends Model
{
	protected $table = "task";

	/*
	|----------------------------------------------------------------
	|	Validation rules
	|----------------------------------------------------------------
	*/
	public $rules = array(
        'task_desc'		=> 'required',
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
