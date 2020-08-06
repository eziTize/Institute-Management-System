<?php

/*
|----------------------------------------------------------------
|	Marketing Person Routes
|----------------------------------------------------------------
*/
Route::group(array('prefix' => env('marketing_person'),'namespace' => 'MarketingPerson'), function(){
    Route::get('/','AdminController@root');
    Route::get('login','AdminController@index');
    Route::post('login','AdminController@login');
    Route::get('logout','AdminController@logout');
    Route::post('loginWithID/{id}','AdminController@loginWithID');

    Route::group(['middleware' => 'marketing_person'], function(){
        
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
        Route::get('enquiry_leads/excel_format_download','EnquiryLeadsController@excel_format_download');
        Route::post('enquiry_leads/bulk_upload','EnquiryLeadsController@bulk_upload');
        Route::resource('enquiry_leads','EnquiryLeadsController');

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
        |   Manage Seminars
        |----------------------------------------------------------
        */

        // Seminars Add Upload Field
        Route::get('seminars/addUploadField','SeminarController@addUploadField');


        // Seminars Delete Upload Field
        Route::get('seminars/deleteUploadField/{id}','SeminarController@deleteUploadField');


         // Create Seminars page
        Route::get('seminars/add','SeminarController@create');

        // Store Seminars Route
        Route::post('seminars/store','SeminarController@store');


        // List Seminars Route
        Route::get('seminars','SeminarController@index');


        // Edit Seminars page
        Route::get('seminars/{id}/edit','SeminarController@edit');


        // Update Seminars Route
        Route::put('seminars/{id}/update','SeminarController@update');
        

        // Upload Image(s) page
        Route::get('seminars/{id}/upload-image','SeminarController@uploadImage');


        // Store Image(s) Route
        Route::put('seminars/{id}/store-image','SeminarController@storeImage');


        // Show Single Seminar
        //Route::get('seminars/{id}/view','SeminarController@show');
            

        // Destroy (trash)
        Route::patch('seminars/destroy/{id}','SeminarController@destroy');




        /*
        |----------------------------------------------------------
        |   Manage Workshop
        |----------------------------------------------------------
        */

        // Workshop Add Upload Field
        Route::get('workshop/addUploadField','WorkshopController@addUploadField');


        // Workshop Delete Upload Field
        Route::get('workshop/deleteUploadField/{id}','WorkshopController@deleteUploadField');


         // Create Workshop page
        Route::get('workshop/add','WorkshopController@create');

        // Store Workshop Route
        Route::post('workshop/store','WorkshopController@store');


        // List Workshop Route
        Route::get('workshop','WorkshopController@index');


        // Edit Workshop page
        Route::get('workshop/{id}/edit','WorkshopController@edit');


        // Update Workshop Route
        Route::put('workshop/{id}/update','WorkshopController@update');
            

        // Destroy Workshop (trash)
        Route::patch('workshop/destroy/{id}','WorkshopController@destroy');


        // Upload Image(s) page
        Route::get('workshop/{id}/upload-image','WorkshopController@uploadImage');


        // Store Image(s) Route
        Route::put('workshop/{id}/store-image','WorkshopController@storeImage');


        /*
        |----------------------------------------------------------
        |   Manage Tour
        |----------------------------------------------------------
        */

        // Tour Add Upload Field
        Route::get('tour/addUploadField','TourController@addUploadField');


        // Tour Delete Upload Field
        Route::get('tour/deleteUploadField/{id}','TourController@deleteUploadField');


         // Create Tour page
        Route::get('tour/add','TourController@create');

        // Store Tour Route
        Route::post('tour/store','TourController@store');


        // List Tour Route
        Route::get('tour','TourController@index');


        // Edit Tour page
        Route::get('tour/{id}/edit','TourController@edit');


        // Update Tour Route
        Route::put('tour/{id}/update','TourController@update');
            

        // Destroy Tour (trash)
        Route::patch('tour/destroy/{id}','TourController@destroy');


        // Upload Image(s) page
        Route::get('tour/{id}/upload-image','TourController@uploadImage');


        // Store Image(s) Route
        Route::put('tour/{id}/store-image','TourController@storeImage');


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