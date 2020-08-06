<?php

namespace App\Http\Controllers\Telecaller;

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
        
        $telecaller_id = Auth::guard('telecaller')->user()->id;

         $data = [
            'data' => Notification::where('telecaller_id', $telecaller_id)->get(),
            'link' => env('telecaller').'/notifications/'
        ];
        return View('telecaller.notifications.index',$data);
    }


    /*
    |------------------------------------------------------------------
    |   Delete Notification
    |------------------------------------------------------------------
    */
    public function destroy($id){

        $data = Notification::find($id);
        $data->delete();

        return Redirect(env('telecaller').'/notifications');
    }

}
