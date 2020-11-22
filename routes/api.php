<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::namespace('App\Http\Controllers')->group(function () {
    Route::post('login', 'UserController@login')->name('login-user');
    Route::post('admin/login', 'AdminController@login')->name('admin-login');
    Route::post('service-provider/login', 'ServiceProviderController@login')->name('service-provider-login');
    Route::post('rigister', 'UserController@register')->name('register-user');
    Route::post('forget-password', 'UserController@forgetPassword')->name('forget-password');
    Route::post('reset-password', 'UserController@resetPassword')->name('reset-password');

    Route::middleware('auth:api')->group(function ()
    {
        Route::prefix('users')->group(function (){
            Route::get('/service-provider/distance', 'UserController@distance')->name('user-distance');
            Route::post('/reservation/{serviceProvider}', 'UserController@reservation')->name('user-reservation');
            Route::get('/intervals/{serviceProvider}', 'ServiceProviderController@intervals')->name('intervals');
        });
    });

    Route::middleware('auth:admin')->group(function ()
    {
        Route::resource('users', 'UserController');
        Route::resource('service-providers', 'ServiceProviderController', [
            'names' => [
                'index' => 'all-service-provider',
                'store' => 'store-service-provider',
                'show' => 'show-service-provider',
                'update' => 'update-service-provider',
                'destroy' => 'delete-service-provider',
            ]
        ]);
        
        Route::prefix('admin')->group(function (){
            Route::post('commission', 'AdminController@commission');            
        });
    });

});
