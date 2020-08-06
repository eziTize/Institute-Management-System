<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use DB;
use File;

class Media extends Model
{
    protected $table = "media";

    /*
    |----------------------------------------------------------------
    |   Validation rules
    |----------------------------------------------------------------
    */
    public $rules = array(
        'media_name'    => 'required|max:255',
        'media_file'    => 'required'
    );
    
    public $erules = array(
        'media_name'    => 'required|max:255'
    );

    /*
    |----------------------------------------------------------------
    |   Validate data for add & update records
    |----------------------------------------------------------------
    */
    public function validate($data,$type){
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
	
	public static function addNew($data){
        if(isset($data['media_name']) && isset($data['media_file'])){
            $add = new Media;
            $add->media_name = $data['media_name'];
            
            $filename  = time().rand(222,699).'.' .$data['media_file']->getClientOriginalExtension();
            $data['media_file']->move("upload/media/", $filename);
            $add->media_file = $filename;
            
            $add->save();

            return true;
        }

        return false;
    }

    public static function updateExist($data){
        if(isset($data['media_name'])){
            $edit = Media::find($data['id']);
            $edit->media_name = $data['media_name'];

            if(isset($data['media_file'])){
                File::delete("upload/media/".$edit->media_file);

                $filename  = time().rand(222,699).'.' .$data['media_file']->getClientOriginalExtension();
                $data['media_file']->move("upload/media/", $filename);
                $edit->media_file = $filename;
            }

            $edit->save();

            return true;
        }

        return false;
    }
    
    public static function deleteDoc($id){
        $del = Media::find($id);

        File::delete("upload/media/".$del->media_file);

        $del->delete();
    }
}