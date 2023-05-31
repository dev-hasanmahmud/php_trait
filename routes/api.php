<?php

use Illuminate\Http\Request;
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

// Route::post('/login','Api\LoginController@login');


Route::prefix('/emcrp')->group(function(){
    Route::post('/login','Api\LoginController@login');
   // Route::get('user','Api\LoginController@index');
    Route::middleware('auth:api')->group(function(){

        Route::get('dashboard-menu','Api\LoginController@index');
        //Route::get('valid/user','Api\LoginController@index');
        Route::get('all-package','Api\PackageController@index');
        Route::get('data-for-image-upload-from','Api\PackageController@all_package');
        Route::post('package-dashboard','Api\PackageController@package_dashboard');

        Route::post('report-dashboard','Api\DashboardReportController@index'); //report dashboard with filtering
        Route::post('package-wise-report','Api\DashboardReportController@package_wise_report'); //report dashboard with filtering

        Route::post('gallery','Api\ImageGalleryController@index'); //image gallery with filtering
        Route::post('procurement','Api\ProcurementController@index');

        Route::post('upload-image','Api\ImageUploadController@store');  
        Route::get('upload-image-information','Api\ImageUploadController@index');  
        Route::get('image-information','Api\ImageUploadController@dynamic_image'); 

        Route::post('upload-image-list','Api\ImageUploadController@image_list'); 
        Route::get('upload-image-edit/{id}','Api\ImageUploadController@edit'); 
        Route::post('upload-image-update','Api\ImageUploadController@update'); //update
        Route::get('image-show/{id}','Api\ImageUploadController@show');
        Route::post('recommendation','Api\ImageUploadController@recommendation');
        Route::post('image-approve/{id}','Api\ImageUploadController@image_approve');

        Route::post('image-delete/{id}','Api\ImageUploadController@destroy');


        Route::post('gis-information','Api\GisController@index');

        Route::post('/logout','Api\LoginController@logout');
    });
});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
