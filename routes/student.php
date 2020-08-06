<?php



/*

|----------------------------------------------------------------

|	Student Routes

|----------------------------------------------------------------

*/

Route::group(array('prefix' => env('student'),'namespace' => 'Student'), function(){

    Route::get('/','AdminController@root');

    Route::get('login','AdminController@index');

    Route::post('login','AdminController@login');

    Route::get('logout','AdminController@logout');



    Route::group(['middleware' => 'student'], function(){

        

        /*

        |----------------------------------------------------------------

        |   Dashboard & Account Settings

        |----------------------------------------------------------------

        */

        Route::get('dashboard','AdminController@dashboard');

        Route::get('settings','AdminController@settings');

        Route::post('settings','AdminController@update');



        /*

        |----------------------------------------------------------------

        |   Student Helpdesk Complaints

        |----------------------------------------------------------------

        */

        Route::resource('complaints','ComplaintsController')->only([

            'show','store'

        ]);



        /*

        |----------------------------------------------------------------

        |   Student Helpdesk Feedbacks

        |----------------------------------------------------------------

        */

        Route::resource('feedbacks','FeedbacksController')->only([

            'show','store'

        ]);



        /*

        |----------------------------------------------------------------

        |   Student Helpdesk Applications

        |----------------------------------------------------------------

        */

        Route::resource('applications','ApplicationsController')->only([

            'show','store'

        ]);



        /*

        |----------------------------------------------------------------

        |   Get and Print Student ID Card

        |----------------------------------------------------------------

        */

        Route::get('getIDCard','AdminController@getIDCard');

        Route::get('printIDCard','AdminController@printIDCard');


        /*
        |----------------------------------------------------------
        |   Manage Openings
        |----------------------------------------------------------
        */


        // List Openings Route
        Route::get('openings','PlacementController@index');


        // Send Application Page
        Route::get('openings/{id}/send-application','PlacementController@SendApplication');

        // Apply for Opening
        Route::post('openings/{id}/apply','PlacementController@applyforOpening');


        // Single Opening Page
        Route::get('openings/{id}/view','PlacementController@show');


         // List Openings Route
        Route::get('job-offers','PlacementController@jobOffers');


        // Download Offer Letter
        Route::get('openings/{id}/download-letter','PlacementController@downloadOfferLetter');



        /*
        |----------------------------------------------------------
        |   Manage Notifications
        |----------------------------------------------------------
        */


        // List Notifications
        Route::get('notifications','NotificationController@index');

        // Delete Notification
        Route::delete('notifications/destroy/{id}','NotificationController@destroy');


        /*
        |----------------------------------------------------------
        |   Manage Marksheet
        |----------------------------------------------------------
        */

            // List all available Marksheet
            Route::get('marksheet','MarksheetController@index');

            // Show Single Marksheet
           Route::get('marksheet/{id}/view','MarksheetController@show');


    });

});