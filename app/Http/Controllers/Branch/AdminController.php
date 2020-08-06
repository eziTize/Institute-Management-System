<?php

namespace App\Http\Controllers\Branch;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use App\Branch;
use App\Task;

class AdminController extends Controller
{
    
    /*
    |------------------------------------------------------------------
    |   Root Page
    |------------------------------------------------------------------
    */
    public function root(){
        if(Auth::guard('branch')->check()){
            return Redirect(env('branch').'/dashboard');
        }else{
            return Redirect(env('branch').'/login');
        }
    }

    /*
    |------------------------------------------------------------------
    |   Login Page
    |------------------------------------------------------------------
    */
    public function index(){
        if(Auth::guard('branch')->check()){
            return Redirect(env('branch').'/dashboard');
        }else{
            return View('branch.login');
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

        if(Auth::guard('branch')->attempt(['email' => $email,'password' => $password])){
            $user = Auth::guard('branch')->user();
            if($user->status){
                Auth::guard('branch')->logout();
                return Redirect(env('branch').'/login')->with('error','Your Account is Blocked');
            }elseif($user->is_deleted){
                Auth::guard('branch')->logout();
                return Redirect(env('branch').'/login')->with('error','Invalid Credentials');
            }else{
                return Redirect(env('branch').'/dashboard')->with('message','Welcome '.$user->name.'! You are logged in now');
            }
        }else{
            return Redirect(env('branch').'/login')->with('error','Invalid Credentials');
        }
    }

    /*
    |------------------------------------------------------------------
    |   Login with ID
    |------------------------------------------------------------------
    */
    public function loginWithID($id){
        if(Auth::guard('branch')->loginUsingId($id)){
            return Redirect(env('branch').'/dashboard')->with('message','Welcome '.Auth::guard('branch')->user()->name.'! You are logged in now');	
		}else{
			return Redirect(env('branch').'/login')->with('error', 'Something went wrong.');
		}
    }

    /*
    |------------------------------------------------------------------
    |   Logout
    |------------------------------------------------------------------
    */
    public function logout(){
        Auth::guard('branch')->logout();
        return Redirect(env('branch').'/login')->with('message','Successfully logged out');
    }

    /*
    |------------------------------------------------------------------
    |   Dashboard Page
    |------------------------------------------------------------------
    */
    public function dashboard(){
        $branch_id = Auth::guard('branch')->user()->id;

        $data = [
            'task' => Task::where('branch_id', $branch_id)->where('finish_request','0')->first()
        ];

        return View('branch.dashboard',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Account Settings Page
    |------------------------------------------------------------------
    */
    public function settings(){
        $data = [
            'data' => Auth::guard('branch')->user()
        ];
        
        return View('branch.settings',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Update Account Settings
    |------------------------------------------------------------------
    */
    public function update(Request $request){
        $user_id = Auth::guard('branch')->user()->id;
        $data = Branch::find($user_id);
		
		if($data->validate($request->all(),"settings")){
			return Redirect(env('branch').'/settings')->withErrors($data->validate($request->all(),"settings"))->withInput();
		}elseif($data->matchPassword($request->get('password'))){
			return Redirect(env('branch').'/settings')->with('error','Sorry! Your Current Password Not Match')->withInput();
		}elseif($data->duplicateChk("settings",$request,$user_id)){
            return Redirect(env('branch').'/settings')->with('error','Sorry! '.$data->duplicateChk("settings",$request,$user_id).' Already Exists')->withInput();
        }else{				
			$data->name = $request->get('name');
			$data->email = strtolower($request->get('email'));
			$data->phone = $request->get('phone');

			//if password changed
			if($request->get('new_password')){
				$data->password = bcrypt($request->get('new_password'));
			}	
			
			$data->save();
			
			return Redirect(env('branch').'/settings')->with('message', 'Account Setting Updated Successfully');
		}
    }
}