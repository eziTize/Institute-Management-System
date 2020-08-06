<?php

namespace App;

use Validator;

use Illuminate\Database\Eloquent\Model;

class ExtraFees extends Model
{
    //

    protected $table = "extra_fees";

/*
	|----------------------------------------------------------------
	|	Validation rules
	|----------------------------------------------------------------
	*/
	public $rules = array(

            'fee_type' 		    	=> 'required|max:255',
        	'fee_amount' 	    	=> 'required|numeric'
   );

    /*
	|----------------------------------------------------------------
	|	Validate data for updating records
	|----------------------------------------------------------------
	*/
    public function validate($data){
        
            $ruleType = $this->rules;

       $validator = Validator::make($data, $ruleType);

       if($validator->fails()){
            return $validator;
       }
	}
	
	/*
	|------------------------------------------------------------------
	|	If duplicate Fee Type entered 
	|------------------------------------------------------------------
	*/
	public function duplicateChk($request,$slug=0){
		$fee_type = strtolower($request->get('fee_type'));

            if(ExtraFees::where('slug','!=',$slug)->where('fee_type',$fee_type)->exists()){
				return "Fee Type";
			}else{
				return false;
			}
	}
}
