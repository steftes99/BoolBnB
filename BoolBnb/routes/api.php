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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')
->name('api.')
->prefix('api')
->group(function(){
    Route::resource('apartments', ApartmentController::class)->only(['index', 'show','update']);
});

Route::get('orders', 'Api\Orders\OrderController@generate');
Route::post('make/payment', 'Api\Orders\OrderController@makePayment');