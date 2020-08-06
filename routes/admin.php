<?php

/*
|----------------------------------------------------------------
|	Admin Routes
|----------------------------------------------------------------
*/
Route::group(array('prefix' => env('admin'),'namespace' => 'Admin'), function(){
    Route::get('/','AdminController@root');
    Route::get('login','AdminController@index');
    Route::post('login','AdminController@login');
    Route::get('logout','AdminController@logout');

    Route::group(['middleware' => 'admin'], function(){
        
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
        |   Manage Branch User
        |----------------------------------------------------------
        */
        Route::get('branch/trash','BranchController@trash');
        Route::post('branch/restore/{id}','BranchController@restore');
        Route::delete('branch/destroy_permanent/{id}','BranchController@destroyPermanent');
        Route::get('branch/{id}/add_course','BranchController@addCourse');
        Route::post('branch/{id}/add_course','BranchController@addCourseStore');
        Route::get('branch/{id}/add_task','BranchController@addTask');
        Route::post('branch/{id}/add_task','BranchController@addTaskStore');
        Route::post('branch/{id}/finish_task','BranchController@finishTask');
        Route::resource('branch','BranchController');

        /*
        |----------------------------------------------------------
        |   Manage Telecaller User
        |----------------------------------------------------------
        */
        Route::get('telecaller/trash','TelecallerController@trash');
        Route::post('telecaller/restore/{id}','TelecallerController@restore');
        Route::delete('telecaller/destroy_permanent/{id}','TelecallerController@destroyPermanent');
        Route::get('telecaller/{id}/add_task','TelecallerController@addTask');
        Route::post('telecaller/{id}/add_task','TelecallerController@addTaskStore');
        Route::post('telecaller/{id}/finish_task','TelecallerController@finishTask');
        Route::resource('telecaller','TelecallerController');

        /*
        |----------------------------------------------------------
        |   Manage Tpo User
        |----------------------------------------------------------
        */
        Route::get('tpo/trash','TpoController@trash');
        Route::post('tpo/restore/{id}','TpoController@restore');
        Route::delete('tpo/destroy_permanent/{id}','TpoController@destroyPermanent');
        Route::get('tpo/{id}/add_task','TpoController@addTask');
        Route::post('tpo/{id}/add_task','TpoController@addTaskStore');
        Route::post('tpo/{id}/finish_task','TpoController@finishTask');
        Route::resource('tpo','TpoController');

        /*
        |----------------------------------------------------------
        |   Manage Marketing Person User
        |----------------------------------------------------------
        */
        Route::get('marketing_person/trash','MarketingPersonController@trash');
        Route::post('marketing_person/restore/{id}','MarketingPersonController@restore');
        Route::delete('marketing_person/destroy_permanent/{id}','MarketingPersonController@destroyPermanent');
        Route::get('marketing_person/{id}/add_task','MarketingPersonController@addTask');
        Route::post('marketing_person/{id}/add_task','MarketingPersonController@addTaskStore');
        Route::post('marketing_person/{id}/finish_task','MarketingPersonController@finishTask');
        Route::resource('marketing_person','MarketingPersonController');

        /*
        |----------------------------------------------------------
        |   Manage Teacher User
        |----------------------------------------------------------
        */
        Route::get('teacher/trash','TeacherController@trash');
        Route::post('teacher/restore/{id}','TeacherController@restore');
        Route::delete('teacher/destroy_permanent/{id}','TeacherController@destroyPermanent');
        Route::get('teacher/{id}/add_task','TeacherController@addTask');
        Route::post('teacher/{id}/add_task','TeacherController@addTaskStore');
        Route::post('teacher/{id}/finish_task','TeacherController@finishTask');
        Route::resource('teacher','TeacherController');

        /*
        |----------------------------------------------------------
        |   Manage Enquiry Leads
        |----------------------------------------------------------
        */
        Route::get('enquiry_leads/not_replied','EnquiryLeadsController@not_replied');
        Route::post('enquiry_leads/assign/{id}','EnquiryLeadsController@assign');
        Route::resource('enquiry_leads','EnquiryLeadsController');

        /*
        |----------------------------------------------------------
        |   Manage Course
        |----------------------------------------------------------
        */
        Route::get('course/trash','CourseController@trash');
        Route::post('course/restore/{id}','CourseController@restore');
        Route::delete('course/destroy_permanent/{id}','CourseController@destroyPermanent');
        Route::resource('course','CourseController');

        /*
        |----------------------------------------------------------
        |   Manage Batch
        |----------------------------------------------------------
        */
        Route::get('batch/trash','BatchController@trash');
        Route::post('batch/restore/{id}','BatchController@restore');
        Route::delete('batch/destroy_permanent/{id}','BatchController@destroyPermanent');
        Route::resource('batch','BatchController');

        /*
        |----------------------------------------------------------
        |   Manage Enquiry Source
        |----------------------------------------------------------
        */
        Route::get('enquiry_src/trash','EnquirySrcController@trash');
        Route::post('enquiry_src/restore/{id}','EnquirySrcController@restore');
        Route::delete('enquiry_src/destroy_permanent/{id}','EnquirySrcController@destroyPermanent');
        Route::resource('enquiry_src','EnquirySrcController');


        /*
        |----------------------------------------------------------
        |   Manage Fees
        |----------------------------------------------------------
        */

            // List all available Fees
            Route::get('fees','FeesController@index')->name('fees.index');

            // Create Fees page
            Route::get('fees/add','FeesController@create');

            // Store Fees Route
            Route::post('fees/store','FeesController@store');

            // Show Single Fee
           Route::get('fees/{id}/view','FeesController@show')->name('fee.show');

            // Show all Trashed Fees
            Route::get('fees/trash','FeesController@trash');
            

            //Destroy Permanent
            Route::delete('fees/destroy_permanent/{id}','FeesController@destroyPermanent');

            // Destroy (trash)
            Route::patch('fees/destroy/{id}','FeesController@destroy');

            // Restore (from Trash)
            Route::patch('fees/restore/{id}','FeesController@restore');

        //Route::resource('fees','FeesController');


        /*
        |----------------------------------------------------------
        |   Manage Extra Fees
        |----------------------------------------------------------
        */
        
        Route::resource('fee-settings','ExtraFeesController');



        /*
        |----------------------------------------------------------------
        | Student Helpdesk Complaints
        |----------------------------------------------------------------
        */
        Route::get('complaints/trash','ComplaintsController@trash');
        Route::post('complaints/restore/{id}','ComplaintsController@restore');
        Route::delete('complaints/destroy_permanent/{id}','ComplaintsController@destroyPermanent');
        Route::resource('complaints','ComplaintsController')->only([
        'index','edit','destroy'
        ]);

        /*
        |----------------------------------------------------------------
        | Student Helpdesk Feedbacks
        |----------------------------------------------------------------
        */
        Route::get('feedbacks/trash','FeedbacksController@trash');
        Route::post('feedbacks/restore/{id}','FeedbacksController@restore');
        Route::delete('feedbacks/destroy_permanent/{id}','FeedbacksController@destroyPermanent');
        Route::resource('feedbacks','FeedbacksController')->only([
        'index','edit','destroy'
        ]);

        /*
        |----------------------------------------------------------------
        | Student Helpdesk Applications
        |----------------------------------------------------------------
        */
        Route::get('applications/trash','ApplicationsController@trash');
        Route::post('applications/restore/{id}','ApplicationsController@restore');
        Route::delete('applications/destroy_permanent/{id}','ApplicationsController@destroyPermanent');
        Route::resource('applications','ApplicationsController')->only([
        'index','edit','destroy'
        ]);


        /*
        |----------------------------------------------------------
        |   Manage Marksheet
        |----------------------------------------------------------
        */

            // List all available Marksheet
            Route::get('marksheet','MarksheetController@index');

            // Create Marksheet page
            Route::get('marksheet/add','MarksheetController@create');

            // Store Marksheet Route
            Route::post('marksheet/store','MarksheetController@store');

            // Show Single Marksheet
           Route::get('marksheet/{id}/view','MarksheetController@show');

            // Show all Trashed Marksheet
            Route::get('marksheet/trash','MarksheetController@trash');
            

            // Edit Marksheet
           Route::get('marksheet/{id}/edit','MarksheetController@edit');

            // Update Marksheet
           Route::post('marksheet/{id}/update','MarksheetController@update');

            //Destroy Permanent
            Route::delete('marksheet/destroy_permanent/{id}','MarksheetController@destroyPermanent');

            // Destroy (trash)
            Route::patch('marksheet/destroy/{id}','MarksheetController@destroy');

            // Restore (from Trash)
            Route::patch('marksheet/restore/{id}','MarksheetController@restore');


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