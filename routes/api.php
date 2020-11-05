<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('admin')->group(function () {
    Route::get('users', function () {
        // Matches The "/admin/users" URL
    });
});


Route::namespace('App\Http\Controllers')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('users', 'AuthController@register');
    Route::post('forget_password', 'AuthController@forgetPassword');

});
