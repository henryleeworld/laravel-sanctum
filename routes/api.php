<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers\Api\V1'], function () {
	// Public routes
    Route::post('/login', 'LoginController@login');
    Route::post('/register', 'RegisterController@register');

    // Protected routes
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/logout', 'LoginController@logout');
        Route::resource('/tasks', 'TasksController');
    });
});
