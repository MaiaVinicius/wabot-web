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
Route::get('/queue', 'DashboardController@queue')->name("queue");
Route::get('/interaction', 'DashboardController@listInteractions')->name("interaction");
Route::get('/exec', 'DashboardController@exec')->name("exec");
