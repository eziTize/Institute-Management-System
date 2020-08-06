<?php

namespace App\Http\Controllers\Telecaller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Job;
use App\JobComment;

class JobController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Job List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $telecaller_id = Auth::guard('telecaller')->user()->id;
        
        $data = [
            'data' => Job::where('telecaller_id', $telecaller_id)->get(),
            'job_comment' => new JobComment,
            'link' => env('telecaller').'/job/'
        ];

        return View('telecaller.job.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Add Comment for Job
    |------------------------------------------------------------------
    */
    public function addComment(Request $request,$id){
        $data = new JobComment;

        if($data->validate($request->all())){
            return Redirect(env('telecaller').'/job')->withErrors($data->validate($request->all()))->withInput();
        }
        
        $data->job_id = $id;
        $data->comment = $request->get('comment');
        $data->save();

        return Redirect(env('telecaller').'/job')->with('message','Comment Made Successfully.');
    }

    /*
    |------------------------------------------------------------------
    |   Finish Job Request
    |------------------------------------------------------------------
    */
    public function finishJob(Request $request,$id){
        $data = Job::where('id',$id)->where('status','0')->update(['finish_request' => '1']);

        return Redirect(env('telecaller').'/job')->with('message','Job Finished Successfully.');
    }
}
