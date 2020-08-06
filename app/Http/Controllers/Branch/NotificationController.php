<?php

namespace App\Http\Controllers\Branch;

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
        
        $branch_id = Auth::guard('branch')->user()->id;

         $data = [
            'data' => Notification::where('branch_id', $branch_id)->get(),
            'link' => env('branch').'/notifications/'
        ];
        return View('branch.notifications.index',$data);
    }


    /*
    |------------------------------------------------------------------
    |   Delete Notification
    |------------------------------------------------------------------
    */
    public function destroy($id){

        $data = Notification::find($id);
        $data->delete();

        return Redirect(env('branch').'/notifications');
    }

}
