<?php

use Illuminate\Http\Request;

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

Route::namespace('Api')->prefix('v1')->group(function() {

    /*
        USER
     */
    Route::prefix('investments')->group(function() {
        Route::post('', 'InvestmentController@store');
    });


    /*
        ADMIN
    */
    Route::namespace('Admin')->prefix('admin')->group(function() {
        Route::group(['middleware' => ['api'] ], function() {
            Route::resource('investments', 'InvestmentController', ['names' => 'admin.investments']);
        });
    });
  
});