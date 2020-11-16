<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::namespace('App\Http\Controllers')->group(function () {
    Route::post('login', 'UserController@login')->name('login-user');
    Route::post('admin/login', 'AdminController@login')->name('admin-login');
    Route::post('service-provider/login', 'ServiceProviderController@login')->name('service-provider-login');
    Route::post('users', 'UserController@register')->name('register-user');
    Route::post('forget-password', 'UserController@forgetPassword')->name('forget-password');
    Route::post('reset-password', 'UserController@resetPassword')->name('reset-password');

    Route::middleware('auth:api')->group(function ()
    {
        Route::prefix('users')->group(function (){
            Route::get('/service-provider/distance', 'UserController@distance')->name('user-distance');
            Route::post('/reservation/{serviceProvider}', 'UserController@reservation')->name('user-reservation');
        });
    });

    Route::middleware('auth:admin')->group(function ()
    {
        Route::prefix('service-providers')->group(function (){ // resource
            Route::post('/', 'ServiceProviderController@store')->name('store-service-provider');
            Route::get('/', 'ServiceProviderController@all')->name('all-service-provider');
            Route::get('/{serviceProvider}', 'ServiceProviderController@show')->name('show-service-provider');
            Route::post('/{serviceProvider}', 'ServiceProviderController@update')->name('update-service-provider');
            Route::delete('/{serviceProvider}', 'ServiceProviderController@delete')->name('delete-service-provider'); 
        });
        
        Route::prefix('admin')->group(function (){
            Route::post('commission', 'AdminController@commission');            
        });
    });

});
