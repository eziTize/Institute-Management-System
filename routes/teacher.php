<?php

/*
|----------------------------------------------------------------
|	Teacher Routes
|----------------------------------------------------------------
*/
Route::group(array('prefix' => env('teacher'),'namespace' => 'Teacher'), function(){
    Route::get('/','AdminController@root');
    Route::get('login','AdminController@index');
    Route::post('login','AdminController@login');
    Route::get('logout','AdminController@logout');
    Route::post('loginWithID/{id}','AdminController@loginWithID');

    Route::group(['middleware' => 'teacher'], function(){
        
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
        |   Manage Notifications
        |----------------------------------------------------------
        */


        // List Notifications
        Route::get('notifications','NotificationController@index');

        // Delete Notification
        Route::delete('notifications/destroy/{id}','NotificationController@destroy');
        
    });
});