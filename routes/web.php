<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'App\Http\Controllers\WebController@home')->name('home');
Route::get('/history', 'App\Http\Controllers\WebController@history')->name('history');

Route::prefix('load')->group(function () {
    Route::post('/weatherload', 'App\Http\Controllers\ApiController@weatherLoad')->name('whaterload');
    Route::post('/searchcity', 'App\Http\Controllers\ApiController@searchCitys')->name('searchcity');   
});

