<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {

    Route::post('login', 'Api\v1\Auth\LoginController@action');
    Route::post('logout', 'Api\v1\Auth\LogoutController@action');
    Route::post('reg', 'Api\v1\Auth\RegisterController@action');
    Route::get('me', 'Api\v1\Auth\MeController@action');


    //Emloyee 
    Route::get('employee', 'Api\v1\EmployeeController@index');
    Route::get('employee/{id}/show', 'Api\v1\EmployeeController@show');

    //Pre-Register
    Route::get('preregister/{id?}', 'Api\v1\PreRegisterController@index'); //done
    Route::post('preregister', 'Api\v1\PreRegisterController@store'); //done
    Route::get('preregister/{id}/show', 'Api\v1\PreRegisterController@show'); //done
    Route::put('preregister/{id}/', 'Api\v1\PreRegisterController@update'); //done
    Route::delete('preregister/{id}', 'Api\v1\PreRegisterController@destroy'); //done
    Route::post('preregister/check-preregister/', 'Api\v1\PreRegisterController@check_pre_visitor'); //done
    Route::post('preregister/find_visitor/', 'Api\v1\PreRegisterController@find_visitor'); //done

    Route::get('attendance/{date?}', 'Api\v1\AttendanceController@index');
    Route::get('attendance/user/status', 'Api\v1\AttendanceController@getStatus');
    Route::post('attendance/user/clock-in', 'Api\v1\AttendanceController@clockIn');
    Route::get('attendance/user/clock-out', 'Api\v1\AttendanceController@clockOut');

    Route::get('visitors/', 'Api\v1\VisitorController@index');
    Route::get('visitors/search/{id}', 'Api\v1\VisitorController@search');
    Route::get('visitors/show/{id}', 'Api\v1\VisitorController@show');
    Route::post('visitors/add', 'Api\v1\VisitorController@store');
    Route::put('visitors/edit/{id}', 'Api\v1\VisitorController@update');
    Route::delete('visitors/delete/{id}', 'Api\v1\VisitorController@destroy');
    Route::get('visitor/check-out/{id}', 'Api\v1\VisitorController@checkout');
    Route::post('visitor/check-in', 'Api\v1\VisitorController@checkin');
    Route::get('visitor/change-status/{id}/{status}',  'Api\v1\VisitorController@changeStatus');
    Route::post('visitor/find_visitor/', 'Api\v1\VisitorController@find_visitor'); //done

});
