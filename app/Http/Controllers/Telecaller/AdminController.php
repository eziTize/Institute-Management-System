<?php

namespace App\Http\Controllers\Telecaller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use App\Telecaller;
use App\Task;
use App\EnquiryLeads;

class AdminController extends Controller
{
    
    /*
    |------------------------------------------------------------------
    |   Root Page
    |------------------------------------------------------------------
    */
    public function root(){
        if(Auth::guard('telecaller')->check()){
            return Redirect(env('telecaller').'/dashboard');
        }else{
            return Redirect(env('telecaller').'/login');
        }
    }

    /*
    |------------------------------------------------------------------
    |   Login Page
    |------------------------------------------------------------------
    */
    public function index(){
        if(Auth::guard('telecaller')->check()){
            return Redirect(env('telecaller').'/dashboard');
        }else{
            return View('telecaller.login');
        }
    }

    /*
    |------------------------------------------------------------------
    |   Login Check & Attempt
    |------------------------------------------------------------------
    */
    public function login(Request $request){
        $email = strtolower($request->input('email'));
        $password = $request->input('password');

        if(Auth::guard('telecaller')->attempt(['email' => $email,'password' => $password])){
            $user = Auth::guard('telecaller')->user();
            if($user->status){
                Auth::guard('telecaller')->logout();
                return Redirect(env('telecaller').'/login')->with('error','Your Account is Blocked');
            }elseif($user->is_deleted){
                Auth::guard('telecaller')->logout();
                return Redirect(env('telecaller').'/login')->with('error','Invalid Credentials');
            }else{
                return Redirect(env('telecaller').'/dashboard')->with('message','Welcome '.$user->name.'! You are logged in now');
            }
        }else{
            return Redirect(env('telecaller').'/login')->with('error','Invalid Credentials');
        }
    }

    /*
    |------------------------------------------------------------------
    |   Login with ID
    |------------------------------------------------------------------
    */
    public function loginWithID($id){
        if(Auth::guard('telecaller')->loginUsingId($id)){
            return Redirect(env('telecaller').'/dashboard')->with('message','Welcome '.Auth::guard('telecaller')->user()->name.'! You are logged in now');	
		}else{
			return Redirect(env('telecaller').'/login')->with('error', 'Something went wrong.');
		}
    }

    /*
    |------------------------------------------------------------------
    |   Logout
    |------------------------------------------------------------------
    */
    public function logout(){
        Auth::guard('telecaller')->logout();
        return Redirect(env('telecaller').'/login')->with('message','Successfully logged out');
    }

    /*
    |------------------------------------------------------------------
    |   Dashboard Page
    |------------------------------------------------------------------
    */
    public function dashboard(){
        $telecaller_id = Auth::guard('telecaller')->user()->id;

        $task = Task::where('telecaller_id', $telecaller_id)->where('finish_request','0')->first();

        if($task){
            $from = $task->start_date;
            $to = $task->end_date;

            $assign_count = EnquiryLeads::where('assigned_to', $telecaller_id)->whereBetween('assigned_date',[$from,$to])->where('status','>','0')->count();
            $call_count = EnquiryLeads::where('assigned_to', $telecaller_id)->whereBetween('assigned_date',[$from,$to])->where('status','>','1')->count();
            $walk_in_count = EnquiryLeads::where('assigned_to', $telecaller_id)->whereBetween('assigned_date',[$from,$to])->where('status','>','2')->count();
            $admission_count = EnquiryLeads::where('assigned_to', $telecaller_id)->whereBetween('assigned_date',[$from,$to])->where('status','>','3')->count();
        }else{
            $assign_count = 0;
            $call_count = 0;
            $walk_in_count = 0;
            $admission_count = 0;
        }

        $data = [
            'task' => $task,
            'assign_count' => $assign_count,
            'call_count' => $call_count,
            'walk_in_count' => $walk_in_count,
            'admission_count' => $admission_count
        ];

        return View('telecaller.dashboard',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Account Settings Page
    |------------------------------------------------------------------
    */
    public function settings(){
        $data = [
            'data' => Auth::guard('telecaller')->user()
        ];
        
        return View('telecaller.settings',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Update Account Settings
    |------------------------------------------------------------------
    */
    public function update(Request $request){
        $user_id = Auth::guard('telecaller')->user()->id;
        $data = Telecaller::find($user_id);
		
		if($data->validate($request->all(),"settings")){
			return Redirect(env('telecaller').'/settings')->withErrors($data->validate($request->all(),"settings"))->withInput();
		}elseif($data->matchPassword($request->get('password'))){
			return Redirect(env('telecaller').'/settings')->with('error','Sorry! Your Current Password Not Match')->withInput();
		}elseif($data->duplicateChk("settings",$request,$user_id)){
            return Redirect(env('telecaller').'/settings')->with('error','Sorry! '.$data->duplicateChk("settings",$request,$user_id).' Already Exists')->withInput();
        }else{				
			$data->name = $request->get('name');
			$data->email = strtolower($request->get('email'));
			$data->phone = $request->get('phone');

			//if password changed
			if($request->get('new_password')){
				$data->password = bcrypt($request->get('new_password'));
			}	
			
			$data->save();
			
			return Redirect(env('telecaller').'/settings')->with('message', 'Account Setting Updated Successfully');
		}
    }
}