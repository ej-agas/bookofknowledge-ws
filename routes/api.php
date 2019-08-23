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

Route::group(['prefix' => 'v1'], static function () {

    Route::group(['namespace' => 'Auth'], static function (){
        //
    });

    Route::group(['namespace' => 'Admin'], static function (){
        Route::apiResource('admins', 'AdminApiController');
    });
});
