<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
	// Public routes
    Route::post('/login', 'LoginController@login');
    Route::post('/register', 'RegisterController@register');

    // Protected routes
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/logout', 'LoginController@logout');
        Route::resource('/tasks', 'TasksController');
    });
});