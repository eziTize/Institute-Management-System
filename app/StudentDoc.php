<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
use File;

class StudentDoc extends Authenticatable
{
    protected $table = "student_doc";
	
	public static function addNew($data){
        if(isset($data['doc_type']) && isset($data['doc_file'])){
            $add = new StudentDoc;
            $add->student_id = $data['id'];
            $add->doc_type = $data['doc_type'];
            
            $filename  = time().rand(222,699).'.' .$data['doc_file']->getClientOriginalExtension();
            $data['doc_file']->move("upload/student_doc/", $filename);
            $add->doc_file = $filename;
            
            $add->save();
        }
    }
    
    public static function deleteDoc($id){
        $del = StudentDoc::find($id);

        File::delete("upload/student_doc/".$del->doc_file);

        $del->delete();
    }
}