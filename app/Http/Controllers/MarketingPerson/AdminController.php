<?php

namespace App\Http\Controllers\MarketingPerson;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use App\MarketingPerson;
use App\Task;

class AdminController extends Controller
{
    
    /*
    |------------------------------------------------------------------
    |   Root Page
    |------------------------------------------------------------------
    */
    public function root(){
        if(Auth::guard('marketing_person')->check()){
            return Redirect(env('marketing_person').'/dashboard');
        }else{
            return Redirect(env('marketing_person').'/login');
        }
    }

    /*
    |------------------------------------------------------------------
    |   Login Page
    |------------------------------------------------------------------
    */
    public function index(){
        if(Auth::guard('marketing_person')->check()){
            return Redirect(env('marketing_person').'/dashboard');
        }else{
            return View('marketing_person.login');
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

        if(Auth::guard('marketing_person')->attempt(['email' => $email,'password' => $password])){
            $user = Auth::guard('marketing_person')->user();
            if($user->status){
                Auth::guard('marketing_person')->logout();
                return Redirect(env('marketing_person').'/login')->with('error','Your Account is Blocked');
            }elseif($user->is_deleted){
                Auth::guard('marketing_person')->logout();
                return Redirect(env('marketing_person').'/login')->with('error','Invalid Credentials');
            }else{
                return Redirect(env('marketing_person').'/dashboard')->with('message','Welcome '.$user->name.'! You are logged in now');
            }
        }else{
            return Redirect(env('marketing_person').'/login')->with('error','Invalid Credentials');
        }
    }

    /*
    |------------------------------------------------------------------
    |   Login with ID
    |------------------------------------------------------------------
    */
    public function loginWithID($id){
        if(Auth::guard('marketing_person')->loginUsingId($id)){
            return Redirect(env('marketing_person').'/dashboard')->with('message','Welcome '.Auth::guard('marketing_person')->user()->name.'! You are logged in now');	
		}else{
			return Redirect(env('marketing_person').'/login')->with('error', 'Something went wrong.');
		}
    }

    /*
    |------------------------------------------------------------------
    |   Logout
    |------------------------------------------------------------------
    */
    public function logout(){
        Auth::guard('marketing_person')->logout();
        return Redirect(env('marketing_person').'/login')->with('message','Successfully logged out');
    }

    /*
    |------------------------------------------------------------------
    |   Dashboard Page
    |------------------------------------------------------------------
    */
    public function dashboard(){
        $marketing_person_id = Auth::guard('marketing_person')->user()->id;

        $data = [
            'task' => Task::where('marketing_person_id', $marketing_person_id)->where('finish_request','0')->first()
        ];

        return View('marketing_person.dashboard',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Account Settings Page
    |------------------------------------------------------------------
    */
    public function settings(){
        $data = [
            'data' => Auth::guard('marketing_person')->user()
        ];
        
        return View('marketing_person.settings',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Update Account Settings
    |------------------------------------------------------------------
    */
    public function update(Request $request){
        $user_id = Auth::guard('marketing_person')->user()->id;
        $data = MarketingPerson::find($user_id);
		
		if($data->validate($request->all(),"settings")){
			return Redirect(env('marketing_person').'/settings')->withErrors($data->validate($request->all(),"settings"))->withInput();
		}elseif($data->matchPassword($request->get('password'))){
			return Redirect(env('marketing_person').'/settings')->with('error','Sorry! Your Current Password Not Match')->withInput();
		}elseif($data->duplicateChk("settings",$request,$user_id)){
            return Redirect(env('marketing_person').'/settings')->with('error','Sorry! '.$data->duplicateChk("settings",$request,$user_id).' Already Exists')->withInput();
        }else{				
			$data->name = $request->get('name');
			$data->email = strtolower($request->get('email'));
			$data->phone = $request->get('phone');

			//if password changed
			if($request->get('new_password')){
				$data->password = bcrypt($request->get('new_password'));
			}	
			
			$data->save();
			
			return Redirect(env('marketing_person').'/settings')->with('message', 'Account Setting Updated Successfully');
		}
    }
}