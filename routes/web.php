<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\Web')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/login', 'UserController@login');
        Route::get('/reserve/{serviceProvider}', 'UserController@reservation');
    });
    Route::prefix('admin')->group(function () {
        Route::get('/login', 'AdminController@login')->name('login');
    });
    Route::prefix('service-provider')->group(function () {
        Route::get('/location', 'ServiceProviderController@location');// send lat - long
    });
});

Route::namespace('App\Http\Controllers')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', 'UserController@index');
    });
    Route::prefix('service-provider')->group(function () {
        Route::get('/distance', 'ServiceProviderController@distance');
        Route::get('/{serviceProvider}', 'ServiceProviderController@show');
    });
});