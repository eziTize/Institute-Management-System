<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class TaskComment extends Model
{
	protected $table = "task_comment";

	/*
	|----------------------------------------------------------------
	|	Validation rules
	|----------------------------------------------------------------
	*/
	public $rules = array(
        'comment'	=> 'required'
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
