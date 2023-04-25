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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/pennytestresponse', 'App\Http\Controllers\AdminController@pennyTestResponseController');
Route::get('/tescotestresponse', 'App\Http\Controllers\AdminController@tescoTestResponseController');
//Admin

Route::post('/login', [App\Http\Controllers\ApiControllers\LoginController::class, 'login']);
Route::post('/register', [App\Http\Controllers\ApiControllers\LoginController::class, 'register'])->name('register');
Route::get('/index', [App\Http\Controllers\ApiControllers\ProductController::class, 'index']);
Route::get('/fetchdata', [\App\Http\Controllers\ApiControllers\ProductController::class, 'queryProducts']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/profilemodify', [App\Http\Controllers\ApiControllers\LoginController::class, 'profileModify']);
    Route::get('/logout', [App\Http\Controllers\ApiControllers\LoginController::class, 'logout'])->name('logout');
    Route::get('/admin/getuploadlogs', [\App\Http\Controllers\ApiControllers\AdminController::class, 'getUploadLogs']);
    Route::get('/admin/getpennydatas', [App\Http\Controllers\ApiControllers\AdminController::class, 'getPennyDatas']);
    Route::get('/getshoppingcart', [App\Http\Controllers\ApiControllers\ShoppingCartController::class, 'getUserShoppingCart']);
    Route::get('/admin/getpennydatas/fetchdata', [App\Http\Controllers\ApiControllers\AdminController::class, 'getPennyDatasOrdered']);
    Route::post('/addtoshoppingcart', [App\Http\Controllers\ApiControllers\ShoppingCartController::class, 'addToShoppingCart']);
    Route::post('/addcustomshoppingcart', [App\Http\Controllers\ApiControllers\ShoppingCartController::class, 'addCustomShoppingCart']);
    Route::put('/updateshoppingcart', [App\Http\Controllers\ApiControllers\ShoppingCartController::class, 'updateUserShoppingCart']);
    Route::delete('/deleteshoppingcart/{id}', [App\Http\Controllers\ApiControllers\ShoppingCartController::class, 'deleteShoppingCart']);
    Route::put('/updatecustomshoppingcart', [App\Http\Controllers\ApiControllers\ShoppingCartController::class, 'updateCustomShoppingCart']);
});
