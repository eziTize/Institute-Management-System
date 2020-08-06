<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
use Auth;

class Student extends Authenticatable
{
    protected $table = "student";

	/*
	|----------------------------------------------------------------
	|	Validation rules
	|----------------------------------------------------------------
	*/
	public $rules = array(
		'branch_id'			=> 'required',
		'admission_date'	=> 'date',
		'name'				=> 'required|max:255',
		'father_name'		=> 'required|max:255',
		'mother_name'		=> 'required|max:255',
		'dob'				=> 'date|nullable',
		'phone'				=> 'required|numeric',
		'other_contact'		=> 'numeric|nullable',
		'email'				=> 'required|email|max:255',
		'gender'			=> 'required',
		'state'				=> 'required|max:255',
		'city'				=> 'required|max:255',
		'address'			=> 'required'
    );

    public $erules = array(
		'branch_id'			=> 'required',
		'admission_date'	=> 'date',
		'name'				=> 'required|max:255',
		'father_name'		=> 'required|max:255',
		'mother_name'		=> 'required|max:255',
		'dob'				=> 'date|nullable',
		'phone'				=> 'required|numeric',
		'other_contact'		=> 'numeric|nullable',
		'email'				=> 'required|email|max:255',
		'gender'			=> 'required',
		'state'				=> 'required|max:255',
		'city'				=> 'required|max:255',
		'address'			=> 'required'
    );

    public $adrules = array(
		'branch_id'			=> 'required',
		'admission_date'	=> 'required|date',
		'student_id'		=> 'required',
		'branch_course'		=> 'required',
		'batch'				=> 'required',
		'course_join'		=> 'required|date'
    );

    public $irules = array(
		'name'				=> 'required|max:255',
		'blood_group'		=> 'required',
		'photograph'		=> 'required'
    );

    public $srules = array(
		'login_id'			=> 'required',
		'new_login_id'		=> 'required'
    );

    /*
	|----------------------------------------------------------------
	|	Validate data for add & update records
	|----------------------------------------------------------------
	*/
    public function validate($data,$type){
        if($type == "edit"){
            $ruleType = $this->erules;
        }elseif($type == "add"){
            $ruleType = $this->rules;
        }elseif($type == "make_admission"){
			$ruleType = $this->adrules;
		}elseif($type == "id"){
			$ruleType = $this->irules;
		}else{
			$ruleType = $this->srules;
		}

        $validator = Validator::make($data,$ruleType);

        if($validator->fails()){
            return $validator;
        }
	}
	
	/*
	|------------------------------------------------------------------
	|	If duplicate Email and/or Phone entered for Student with Same Name 
	|------------------------------------------------------------------
	*/
	public function duplicateChk($type,$request,$id=0){
		$name = $request->get('name');
		$email = strtolower($request->get('email'));
		$phone = $request->get('phone');

		if($type == "add"){
			if(Student::where('name',$name)->where('email',$email)->exists()){
				return "Email";
			}elseif(Student::where('name',$name)->where('phone',$phone)->exists()){
				return "Phone";
			}else{
				return false;
			}
		}else{
			if(Student::where('id','!=',$id)->where('name',$name)->where('email',$email)->exists()){
				return "Email";
			}elseif(Student::where('id','!=',$id)->where('name',$name)->where('phone',$phone)->exists()){
				return "Phone";
			}else{
				return false;
			}
		}
	}

	/*
    |------------------------------------------------------------------
    |   Photo Upload for Student ID
    |------------------------------------------------------------------
    */
    public static function addNew($data){
        if($data['photograph']){
            $add = Student::findOrFail($data['id']);

            $filename  = $add->id.'.jpg';
            $data['photograph']->move("upload/student/", $filename);
            $add->photograph = $filename;
            $add->save();

            return true;
        }

        return false;
    }
}