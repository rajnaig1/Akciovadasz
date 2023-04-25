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

Route::get('/', [App\Http\Controllers\ProductController::class, 'index']);
Route::get('/fetchdata', [\App\Http\Controllers\ProductController::class, 'queryProducts']);
Route::get('/books.index', 'App\Http\Controllers\BookController@index');
Route::get('/books.create', 'App\Http\Controllers\BookController@create');
Route::get('/books.show/{_id}', 'App\Http\Controllers\BookController@show');
Route::post('/books.store', 'App\Http\Controllers\BookController@store');
Route::get('/books.edit/{_id}', 'App\Http\Controllers\BookController@edit');
Route::put('/books.update/{_id}', 'App\Http\Controllers\BookController@update');
Route::delete('/books.destroy/{_id}', 'App\Http\Controllers\BookController@destroy');
Route::get('/login', [App\Http\Controllers\LoginController::class, 'loginGet'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login']);
Route::post('/register', [App\Http\Controllers\LoginController::class, 'register'])->name('register');
Route::get('/profileModify', [App\Http\Controllers\LoginController::class, 'registerFailure'])->name('registerFailure');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
    Route::get('/profileModify', function () {
        return view('users.profile');
    })->name('profileModify');
    Route::post('/profileModify', [App\Http\Controllers\LoginController::class, 'profileModify']);
    Route::get('/getshoppingcart', [App\Http\Controllers\ShoppingCartController::class, 'getUserShoppingCart']);
    Route::post('/addtoshoppingcart', [App\Http\Controllers\ShoppingCartController::class, 'addToShoppingCart']);
    Route::put('/updateshoppingcart', [App\Http\Controllers\ShoppingCartController::class, 'updateUserShoppingCart']);
    Route::delete('/deleteshoppingcart/{id}', [App\Http\Controllers\ShoppingCartController::class, 'deleteShoppingCart']);
    Route::post('/addcustomshoppingcart', [App\Http\Controllers\ShoppingCartController::class, 'addCustomShoppingCart']);
    Route::put('/updatecustomshoppingcart', [App\Http\Controllers\ShoppingCartController::class, 'updateCustomShoppingCart']);
    Route::group([
        'prefix' => 'admin',
        'middleware' => 'admin',
        'as' => 'admin.'
    ], function () {
        Route::get('/', [\App\Http\Controllers\AdminController::class, 'getUploadLogs']);
        Route::get('/pennyupload', '\App\Http\Controllers\AdminController@pennyManualUpdate');
        Route::get('/tescoupload', '\App\Http\Controllers\AdminController@tescoManualUpdate');
        Route::get('/getpennydatas', [App\Http\Controllers\AdminController::class, 'getPennyDatas']);
        Route::get('/getpennydatas/fetchdata', [App\Http\Controllers\AdminController::class, 'getPennyDatasOrdered']);
        Route::put('/updatepennyproduct', [App\Http\Controllers\AdminController::class, 'updatePennyProduct']);
        Route::delete('/deletepennyproduct/{id}', [App\Http\Controllers\AdminController::class, 'deletePennyProduct']);
    });
    Route::group([
        'prefix' => 'dev',
        'middleware' => 'dev',
        'as' => 'dev.'
    ], function () {
        Route::get('/test', 'App\Http\Controllers\TestController@index');
    });
});
Route::get('/documentation', function () {
    return phpinfo();
});
