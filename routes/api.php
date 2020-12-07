<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::namespace('App\Http\Controllers')->group(function () {
    Route::post('login', 'UserController@login')->name('login-user');
    Route::post('admin/login', 'AdminController@login')->name('admin-login');
    Route::post('service-provider/login', 'ServiceProviderController@login')->name('service-provider-login');
    Route::post('rigister', 'UserController@store')->name('register-user');
    Route::post('forget-password', 'UserController@forgetPassword')->name('forget-password');
    Route::post('reset-password', 'UserController@resetPassword')->name('reset-password');


    Route::middleware('auth:api')->group(function ()
    {
        Route::prefix('users')->group(function (){
            Route::post('/reservation/{serviceProvider}', 'UserController@reservation')->name('user-reservation');
        });
        Route::prefix('service-provider')->group(function (){
            Route::get('/distance', 'ServiceProviderController@distance')->name('user-distance');
        });
    });

    Route::middleware('auth:admin')->group(function ()
    {
        Route::prefix('admin')->group(function (){
            Route::post('fcm', 'AdminController@fcm')->name('admin-fcm');
        });
        Route::resource('users', 'UserController');
        Route::resource('service-providers', 'ServiceProviderController');
        
        Route::prefix('admin')->group(function (){
            Route::post('commission', 'AdminController@commission')->name('admin-commission');            
        });
    });

});
