<?php

namespace App\Http\Controllers\Branch;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Batch;
use App\BranchCourse;
use App\Branch;
use App\Course;

class BatchController extends Controller
{
    /*
    |------------------------------------------------------------------
    |   Batch List Page
    |------------------------------------------------------------------
    */
    public function index(){
        $branch_id = Auth::guard('branch')->user()->id;
        
        $data = [
            'data' => Batch::where('is_deleted','0')->get(),
            'link' => env('branch').'/batch/'
        ];

        return View('branch.batch.index',$data);
    }

    /*
    |------------------------------------------------------------------
    |   Edit Batch Page
    |------------------------------------------------------------------
    */
    public function edit($id){
        $branch_id = Auth::guard('branch')->user()->id;

        $data = [
            'id' => $id,
            'data' => Batch::branchBatchView($branch_id, $id),
            'link' => env('branch').'/batch/'
        ];

        return View('branch.batch.edit',$data);
    }
}