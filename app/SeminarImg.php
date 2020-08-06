<?php

namespace App;

use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Validator;

use File;


//use Illuminate\Database\Eloquent\Model;

class SeminarImg extends Authenticatable

{

    protected $table = "seminar_imgs";

	

	public static function addNew($data){

        if(isset($data['img_name']) && isset($data['img_file'])){

            $add = new SeminarImg;

            $add->seminar_id = $data['id'];

            $add->img_name = $data['img_name'];

            

            $filename  = time().rand(222,699).'.' .$data['img_file']->getClientOriginalExtension();

            $data['img_file']->move("upload/seminar_imgs/", $filename);

            $add->img_file = $filename;

            

            $add->save();

        }

    }

    

    public static function deleteImg($id){

        $del = SeminarImg::find($id);



        File::delete("upload/seminar_imgs/".$del->img_file);



        $del->delete();

    }

}
