<?php

namespace App\Http\Controllers\MarketingPerson;

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
        
        $mkt_id = Auth::guard('marketing_person')->user()->id;

         $data = [
            'data' => Notification::where('mkt_id', $mkt_id)->get(),
            'link' => env('marketing_person').'/notifications/'
        ];
        return View('marketing_person.notifications.index',$data);
    }


    /*
    |------------------------------------------------------------------
    |   Delete Notification
    |------------------------------------------------------------------
    */
    public function destroy($id){

        $data = Notification::find($id);
        $data->delete();

        return Redirect(env('marketing_person').'/notifications');
    }

}
