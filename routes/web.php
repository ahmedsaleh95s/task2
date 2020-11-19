<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\Web')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/login', 'UserController@login');
        Route::get('/all', 'UserController@all');
    });
    Route::prefix('admin')->group(function () {
        Route::get('/login', 'AdminController@login')->name('login');
    });
});
