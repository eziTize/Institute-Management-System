<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class EnquirySrc extends Model
{
    protected $table = "enquiry_src";

	/*
	|----------------------------------------------------------------
	|	Validation rules
	|----------------------------------------------------------------
	*/
	public $rules = array(
        'name'	=> 'required|max:255'
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
	
	/*
	|------------------------------------------------------------------
	|	If duplicate Name entered 
	|------------------------------------------------------------------
	*/
	public function duplicateChk($type,$request,$id=0){
		$name = strtolower($request->get('name'));

		if($type == "add"){
			if(EnquirySrc::where('name',$name)->exists()){
				return "Name";
			}else{
				return false;
			}
		}else{
            if(EnquirySrc::where('id','!=',$id)->where('name',$name)->exists()){
				return "Name";
			}else{
				return false;
			}
		}
	}
}