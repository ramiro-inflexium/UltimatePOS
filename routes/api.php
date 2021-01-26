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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('validate', function(Request $request){
    \Log::info($request->getContent());
});

Route::post('confirm', function(Request $request){
    \Log::info($request->getContent());
});

Route::group(['prefix' => 'v1', 'as' => 'api.mpesa.', 'namespace' => 'Api\Mpesa'], function () {
    Route::group(['as' => 'c2b.'], function () {
        Route::post('/m-trx/confirm/{confirmation_key}', 'C2BController@confirmTrx')->name('confirm');
        Route::post('/m-trx/validate/{validation_key}', 'C2BController@validateTrx')->name('validate');
        Route::post('/m-trx/simulate', 'C2BController@simulate')->name('simulate');

    });
});
