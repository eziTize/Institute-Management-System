<?php

/*
|----------------------------------------------------------------
|	Telecaller Routes
|----------------------------------------------------------------
*/
Route::group(array('prefix' => env('telecaller'),'namespace' => 'Telecaller'), function(){
    Route::get('/','AdminController@root');
    Route::get('login','AdminController@index');
    Route::post('login','AdminController@login');
    Route::get('logout','AdminController@logout');
    Route::post('loginWithID/{id}','AdminController@loginWithID');

    Route::group(['middleware' => 'telecaller'], function(){
        
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
        |   Manage Enquiry Leads
        |----------------------------------------------------------
        */
        Route::get('enquiry_leads_assigned','EnquiryLeadsController@assigned');
        Route::get('enquiry_leads_called','EnquiryLeadsController@called');
        Route::get('enquiry_leads_walked_in','EnquiryLeadsController@walked_in');
        Route::get('enquiry_leads_admitted','EnquiryLeadsController@admitted');
        Route::post('enquiry_leads_feedback/{id}','EnquiryLeadsController@feedback');
        Route::post('enquiry_leads_make_walk_in/{id}','EnquiryLeadsController@make_walk_in');
        Route::post('enquiry_leads_make_admission/{id}','EnquiryLeadsController@make_admission');

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
        |   Manage Notifications
        |----------------------------------------------------------
        */


        // List Notifications
        Route::get('notifications','NotificationController@index');

        // Delete Notification
        Route::delete('notifications/destroy/{id}','NotificationController@destroy');


    });
});