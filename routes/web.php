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
Route::get('/model-marka-ekle', "AddMarkaModelController@ekle");
Route::get('/verify-account/{token}', 'RegisterAccount\IndexController@verifyEmail');
