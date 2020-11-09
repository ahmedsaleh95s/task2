<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::namespace('App\Http\Controllers')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('admin/login', 'AuthController@adminLogin');
    Route::post('users', 'AuthController@register');
    Route::post('forget-password', 'AuthController@forgetPassword');
    Route::post('reset-password', 'AuthController@resetPassword');


    Route::middleware('auth:admin')->group(function ()
    {
        Route::post('service-providers', 'ServiceProviderController@store');
    });

});
