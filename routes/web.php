<?php

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

Route::get('/', 'DashboardController@index')->name("dashboard");
Route::get('/sent', 'DashboardController@sent')->name("sent");
Route::get('/reply', 'DashboardController@reply')->name("reply");
Route::get('/logs', 'DashboardController@logs')->name("logs");
