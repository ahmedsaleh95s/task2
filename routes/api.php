<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::namespace('App\Http\Controllers')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('users', 'AuthController@register');
    Route::post('forget-password', 'AuthController@forgetPassword');

    Route::middleware('auth:api')->group(function ()
    {
        Route::post('reset-password', 'AuthController@resetPassword');
    });
});
