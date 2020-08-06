<?php

namespace App\Http\Controllers\Tpo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use App\Tpo;
use App\Task;

class AdminController extends Controller
{
    
    /*
    |------------------------------------------------------------------
    |   Root Page
    |------------------------------------------------------------------
    */
    public function root(){
        if(Auth::guard('tpo')->check()){
            return Redirect(env('tpo').'/dashboard');
        }else{
            return Redirect(env('tpo').'/login');
        }
    }

    /*
    |------------------------------------------------------------------
    |   Login Page
    |------------------------------------------------------------------
    */
    public function index(){
        if(Auth::guard('tpo')->check()){
            return Redirect(env('tpo').'/dashboard');
        }else{
            return View('tpo.login');
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

        if(Auth::guard('tpo')->attempt(['email' => $email,'password' => $password])){
            $user = Auth::guard('tpo')->user();
            if($user->status){
                Auth::guard('tpo')->logout();
                return Redirect(env('tpo').'/login')->with('error','Your Account is Blocked');
            }elseif($user->is_deleted){
                Auth::guard('tpo')->logout();
                return Redirect(env('tpo').'/login')->with('error','Invalid Credentials');
            }else{
                return Redirect(env('tpo').'/dashboard')->with('message','Welcome '.$user->name.'! You are logged in now');
            }
        }else{
            return Redirect(env('tpo').'/login')->with('error','Invalid Credentials');
        }
    }

    /*
    |------------------------------------------------------------------
    |   Login with ID
    |------------------------------------------------------------------
    */
    public function loginWithID($id){
        if(Auth::guard('tpo')->loginUsingId($id)){
            return Redirect(env('tpo').'/dashboard')->with('message','Welcome '.Auth::guard('tpo')->user()->name.'! You are logged in now');	
		}else{
			return Redirect(env('tpo').'/login')->with('error', 'Something went wrong.');
		}
    }

    /*
    |------------------------------------------------------------------
    |   Logout
    |------------------------------------------------------------------
    */
    public function logout(){
        Auth::guard('tpo')->logout();
        return Redirect(env('tpo').'/login')->with('message','Successfully logged out');
    }

    /*
    |------------------------------------------------------------------
    |   Dashboard Page
    |------------------------------------------------------------------
    */
    public function dashboard(){
        $tpo_id = Auth::guard('tpo')->user()->id;

        $data = [
            'task' => Task::where('tpo_id', $tpo_id)->where('finish_request','0')->first()
        ];

        return View('tpo.dashboard',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Account Settings Page
    |------------------------------------------------------------------
    */
    public function settings(){
        $data = [
            'data' => Auth::guard('tpo')->user()
        ];
        
        return View('tpo.settings',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Update Account Settings
    |------------------------------------------------------------------
    */
    public function update(Request $request){
        $user_id = Auth::guard('tpo')->user()->id;
        $data = Tpo::find($user_id);
		
		if($data->validate($request->all(),"settings")){
			return Redirect(env('tpo').'/settings')->withErrors($data->validate($request->all(),"settings"))->withInput();
		}elseif($data->matchPassword($request->get('password'))){
			return Redirect(env('tpo').'/settings')->with('error','Sorry! Your Current Password Not Match')->withInput();
		}elseif($data->duplicateChk("settings",$request,$user_id)){
            return Redirect(env('tpo').'/settings')->with('error','Sorry! '.$data->duplicateChk("settings",$request,$user_id).' Already Exists')->withInput();
        }else{				
			$data->name = $request->get('name');
			$data->email = strtolower($request->get('email'));
			$data->phone = $request->get('phone');

			//if password changed
			if($request->get('new_password')){
				$data->password = bcrypt($request->get('new_password'));
			}	
			
			$data->save();
			
			return Redirect(env('tpo').'/settings')->with('message', 'Account Setting Updated Successfully');
		}
    }
}