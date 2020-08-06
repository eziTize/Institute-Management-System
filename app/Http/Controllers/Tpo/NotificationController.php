<?php

namespace App\Http\Controllers\Tpo;

use App\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;



class NotificationController extends Controller
{
   

    /*
    |------------------------------------------------------------------
    |   Notifictions List Page
    |------------------------------------------------------------------
    */
    public function index()
    {
        
        $tpo_id = Auth::guard('tpo')->user()->id;

         $data = [
            'data' => Notification::where('tpo_id', $tpo_id)->get(),
            'link' => env('tpo').'/notifications/'
        ];
        return View('tpo.notifications.index',$data);
    }


    /*
    |------------------------------------------------------------------
    |   Delete Notification
    |------------------------------------------------------------------
    */
    public function destroy($id){

        $data = Notification::find($id);
        $data->delete();

        return Redirect(env('tpo').'/notifications');
    }

}
