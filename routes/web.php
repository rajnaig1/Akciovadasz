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

Route::get('/','App\Http\Controllers\BookController@index');
Route::get('/books.index','App\Http\Controllers\BookController@index');
Route::get('/books.create','App\Http\Controllers\BookController@create');
Route::get('/books.show/{_id}','App\Http\Controllers\BookController@show');
Route::post('/books.store','App\Http\Controllers\BookController@store');
Route::get('/books.edit/{_id}','App\Http\Controllers\BookController@edit');
Route::put('/books.update/{_id}','App\Http\Controllers\BookController@update');
Route::delete('/books.destroy/{_id}','App\Http\Controllers\BookController@destroy');
Route::get('/admin','\App\Http\Controllers\AdminController@getUploadLogs');
Route::get('/admin/pennyupload','\App\Http\Controllers\AdminController@pennyManualUpdate');
Route::get('/test','App\Http\Controllers\TestController@index');
Route::get('/documentation',function(){return phpinfo(); });
