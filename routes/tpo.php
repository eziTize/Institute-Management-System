<?php

/*
|----------------------------------------------------------------
|	Tpo Routes
|----------------------------------------------------------------
*/
Route::group(array('prefix' => env('tpo'),'namespace' => 'Tpo'), function(){
    Route::get('/','AdminController@root');
    Route::get('login','AdminController@index');
    Route::post('login','AdminController@login');
    Route::get('logout','AdminController@logout');
    Route::post('loginWithID/{id}','AdminController@loginWithID');

    Route::group(['middleware' => 'tpo'], function(){
        
        /*
        |----------------------------------------------------------------
        |   Dashboard & Account Settings
        |----------------------------------------------------------------
        */
        Route::get('dashboard','AdminController@dashboard');
        Route::get('settings','AdminController@settings');
        Route::post('settings','AdminController@update');

        /*
        |----------------------------------------------------------
        |   Manage Task
        |----------------------------------------------------------
        */
        Route::post('task/{id}/add_comment','TaskController@addComment');
        Route::post('task/{id}/finish_task','TaskController@finishTask');
        Route::resource('task','TaskController')->only([
            'index'
        ]);


        /*
        |----------------------------------------------------------
        |   Manage Industry Visit
        |----------------------------------------------------------
        */

        // Industry Visit Add Upload Field
        Route::get('industry-visit/addUploadField','IndustryVisitController@addUploadField');


        // Industry Visit Delete Upload Field
        Route::get('industry-visit/deleteUploadField/{id}','IndustryVisitController@deleteUploadField');


         // Create Industry Visit page
        Route::get('industry-visit/add','IndustryVisitController@create');

        // Store Industry Visit Route
        Route::post('industry-visit/store','IndustryVisitController@store');


        // List Industry Visit Route
        Route::get('industry-visit','IndustryVisitController@index');


        // Edit Industry Visit page
        Route::get('industry-visit/{id}/edit','IndustryVisitController@edit');


        // Update Industry Visit Route
        Route::put('industry-visit/{id}/update','IndustryVisitController@update');
            

        // Destroy Industry Visit (trash)
        Route::patch('industry-visit/destroy/{id}','IndustryVisitController@destroy');


        // Upload Image(s) page
        Route::get('industry-visit/{id}/upload-image','IndustryVisitController@uploadImage');


        // Store Image(s) Route
        Route::put('industry-visit/{id}/store-image','IndustryVisitController@storeImage');


        /*
        |----------------------------------------------------------
        |   Manage Internship
        |----------------------------------------------------------
        */

        // Internship Add Upload Field
        Route::get('internship/addUploadField','InternshipController@addUploadField');


        // Internship Delete Upload Field
        Route::get('internship/deleteUploadField/{id}','InternshipController@deleteUploadField');


         // Create Internship page
        Route::get('internship/add','InternshipController@create');

        // Store Internship Route
        Route::post('internship/store','InternshipController@store');


        // List Internship Route
        Route::get('internship','InternshipController@index');


        // Edit Internship page
        Route::get('internship/{id}/edit','InternshipController@edit');


        // Update Internship Route
        Route::put('internship/{id}/update','InternshipController@update');
            

        // Destroy Internship (trash)
        Route::patch('internship/destroy/{id}','InternshipController@destroy');


        // Upload Image(s) page
        Route::get('internship/{id}/upload-image','InternshipController@uploadImage');


        // Store Image(s) Route
        Route::put('internship/{id}/store-image','InternshipController@storeImage');


        /*
        |----------------------------------------------------------
        |   Manage On Job Training
        |----------------------------------------------------------
        */

        // On Job Training Add Upload Field
        Route::get('on-job-training/addUploadField','OJTController@addUploadField');


        // On Job Training Delete Upload Field
        Route::get('on-job-training/deleteUploadField/{id}','OJTController@deleteUploadField');


         // Create On Job Training page
        Route::get('on-job-training/add','OJTController@create');

        // Store On Job Training Route
        Route::post('on-job-training/store','OJTController@store');


        // List On Job Training Route
        Route::get('on-job-training','OJTController@index');


        // Edit On Job Training page
        Route::get('on-job-training/{id}/edit','OJTController@edit');


        // Update On Job Training Route
        Route::put('on-job-training/{id}/update','OJTController@update');
            

        // Destroy On Job Training (trash)
        Route::patch('on-job-training/destroy/{id}','OJTController@destroy');


        // Upload Image(s) page
        Route::get('on-job-training/{id}/upload-image','OJTController@uploadImage');


        // Store Image(s) Route
        Route::put('on-job-training/{id}/store-image','OJTController@storeImage');


        /*
        |----------------------------------------------------------
        |   Manage Openings
        |----------------------------------------------------------
        */


         // Create Openings page Route
        Route::get('openings/add','OpeningsController@create');

        // Store Openings Route
        Route::post('openings/store','OpeningsController@store');


        // List Openings Route
        Route::get('openings','OpeningsController@index');


        // Edit Openings page Route
        Route::get('openings/{id}/edit','OpeningsController@edit');


        // Update Openings Route
        Route::put('openings/{id}/update','OpeningsController@update');
            

        // Destroy Openings (trash) Route
        Route::patch('openings/destroy/{id}','OpeningsController@destroy');


        //Applications List

        Route::get('openings/{id}/applications','OpeningsController@listStudents');


        //Shedule Interview Page

        Route::get('openings/{id}/schedule-interview','OpeningsController@scheduleInterview');


        //Select for Interview

        Route::patch('openings/{id}/select-application','OpeningsController@selectForInterview');


        //Shedule Interview Route (Save/Change Interview Date)

        Route::patch('openings/{id}/schedule-interview-date','OpeningsController@setupInterview');



        //Reject Application

        Route::patch('openings/{id}/reject-application','OpeningsController@rejectApplication');



        //Selected Applications List

        Route::get('openings/{id}/applications/selected','OpeningsController@listSelected');



        //Mark Interviewed

        Route::patch('openings/{id}/mark-interviewed','OpeningsController@markInterviewed');



        //Hired Applicants List

        Route::get('openings/{id}/applications/hired','OpeningsController@listHired');


        //Interviewed Applicants List

        Route::get('openings/{id}/applications/interviewed','OpeningsController@listInterviewed');


        //Hire Applicant

        Route::patch('openings/{id}/hire-applicant','OpeningsController@HireApplicant');



        //Reject Interviewed Application

        Route::patch('openings/{id}/reject-interviewed','OpeningsController@rejectInterviewedApplication');


        //Openings Report Page

        Route::get('placement-reports','OpeningsController@ReportsPage');



        //Report Single View

        Route::get('placement-reports/{id}/view','OpeningsController@ReportSingle');


        //Report Detailed View

        Route::get('placement-reports/{id}/details','OpeningsController@listReport');


        //Send Offer

        Route::get('openings/{id}/send-offer','OpeningsController@sendOffer');


        //Send Offer Letter Route

        Route::patch('openings/{id}/send-offer-letter','OpeningsController@sendOfferLetter');

        // Download CV
        Route::get('openings/{id}/download-cv','OpeningsController@downloadCV');



        /*
        |----------------------------------------------------------
        |   Manage Notifications
        |----------------------------------------------------------
        */


        // List Notifications
        Route::get('notifications','NotificationController@index');

        // Delete Notification
        Route::delete('notifications/destroy/{id}','NotificationController@destroy');

        
    });
});