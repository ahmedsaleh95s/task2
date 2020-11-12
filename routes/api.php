<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::namespace('App\Http\Controllers')->group(function () {
    Route::post('login', 'AuthController@login')->name('login-user');
    Route::post('admin/login', 'AdminController@login')->name('admin-login');
    Route::post('service-provider/login', 'ServiceProviderController@login')->name('service-provider-login');
    Route::post('users', 'AuthController@register')->name('register-user');
    Route::post('forget-password', 'AuthController@forgetPassword')->name('forget-password');
    Route::post('reset-password', 'AuthController@resetPassword')->name('reset-password');


    Route::middleware('auth:admin')->group(function ()
    {
        Route::prefix('service-providers')->group(function (){
            Route::post('/', 'ServiceProviderController@store')->name('store-service-provider');
            Route::get('/', 'ServiceProviderController@all')->name('all-service-provider');
            Route::get('/{id}', 'ServiceProviderController@show')->name('show-service-provider');
            Route::post('/{id}', 'ServiceProviderController@update')->name('update-service-provider');
            Route::delete('/{id}', 'ServiceProviderController@delete')->name('delete-service-provider'); 
        });
    });

});
