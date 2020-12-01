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

    Route::resource('user-service-providers', 'ServiceProviderController', [
        'names' => [
            'index' => 'user-all-service-provider',
            'store' => 'user-store-service-provider',
            'show' => 'user-show-service-provider',
            'update' => 'user-update-service-provider',
            'destroy' => 'user-delete-service-provider',
        ]
    ]);

    Route::middleware('auth:api')->group(function ()
    {
        Route::prefix('users')->group(function (){
            Route::post('/reservation/{serviceProvider}', 'UserController@reservation')->name('user-reservation');
        });
        Route::prefix('service-provider')->group(function (){
            Route::get('/distance', 'ServiceProviderController@distance')->name('user-distance');
        });

        // Route::resource('user-service-providers', 'ServiceProviderController', [
        //     'names' => [
        //         'index' => 'user-all-service-provider',
        //         'store' => 'user-store-service-provider',
        //         'show' => 'user-show-service-provider',
        //         'update' => 'user-update-service-provider',
        //         'destroy' => 'user-delete-service-provider',
        //     ]
        // ]);
    });

    Route::middleware('auth:admin')->group(function ()
    {
        Route::resource('users', 'UserController', [
            'names' => [
                'index' => 'admin-all-users',
                'store' => 'admin-store-users',
                'show' => 'admin-show-user',
                'update' => 'admin-update-user',
                'destroy' => 'admin-delete-user',
            ]
        ]);
        Route::resource('admin-service-providers', 'ServiceProviderController', [
            'names' => [
                'index' => 'admin-all-service-provider',
                'store' => 'admin-store-service-provider',
                'show' => 'admin-show-service-provider',
                'update' => 'admin-update-service-provider',
                'destroy' => 'admin-delete-service-provider',
            ]
        ]);
        
        Route::prefix('admin')->group(function (){
            Route::post('commission', 'AdminController@commission');            
        });
    });

});
