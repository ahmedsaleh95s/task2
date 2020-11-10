<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::namespace('App\Http\Controllers')->group(function () {
    Route::post('login', 'AuthController@login')->name('loginUser');
    Route::post('admin/login', 'AuthController@adminLogin')->name('adminLogin');
    Route::post('users', 'AuthController@register')->name('RegisterUser');
    Route::post('forget-password', 'AuthController@forgetPassword')->name('forgetPassword');
    Route::post('reset-password', 'AuthController@resetPassword')->name('resetPassword');


    Route::middleware('auth:admin')->group(function ()
    {
        Route::post('service-providers', 'ServiceProviderController@store')->name('storeServiceProvider');
    });

});
