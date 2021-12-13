<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::namespace("Guest")
    ->prefix('guest') 
    ->name('guest.') 
    ->group(function(){ 
        Route::resource('apartments', ApartmentController::class)->only(['index', 'show']);
});

Route::namespace("Message")
    ->prefix('message') 
    ->name('message.') 
    ->group(function(){ 
        Route::resource('/', MessageController::class);
});

Route::middleware('auth')  // devi essere autenticato
    ->namespace("Admin") // prendi i controller delle route tue figlie a partire dalla cartella Admin/
    ->prefix('admin') // inserisci come prefisso nelle URI di tutte le route figlie admin/
    ->name('admin.') // inserisci come prefisso per ogni nome di tutte le route figlie admin.
    ->group(function(){ // e raggruppale in:
        Route::resource('apartments', ApartmentController::class);
        Route::get('/', 'HomeController@index')->name('home');
});

Route::get("{any?}", function(){
    return view('welcome');
})->where("any", ".*");