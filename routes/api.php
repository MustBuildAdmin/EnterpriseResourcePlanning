<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('cronmail', 'ProjectReportController@cronmail');
Route::post('login', 'ApiController@login');
Route::resource('task', 'TaskMicroController');
Route::resource('link', 'MicroLinkController');
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', 'ApiController@logout');
    Route::get('get-projects', 'ApiController@getProjects');
    Route::post('add-tracker', 'ApiController@addTracker');
    Route::post('stop-tracker', 'ApiController@stopTracker');
    Route::post('upload-photos', 'ApiController@uploadImage');

    
    
  
});
