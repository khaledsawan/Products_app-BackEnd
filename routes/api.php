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

use App\Http\Controllers\API\PassportAuthController;
use App\Http\Controllers\API\ProductController;

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);


Route::get('index',[ProductController::class,'index']);


Route::middleware('auth:api')->group(function () {
    Route::get('get-user', [PassportAuthController::class, 'userInfo']);
    Route::get('userInfo', [PassportAuthController::class, 'userInfo']);
    Route::post('store',[ProductController::class,'store']);
    Route::post('show',[ProductController::class,'show']);
    Route::post('destroy',[ProductController::class,'destroy']);
    Route::post('update',[ProductController::class,'update']);
    Route::get('myProduct',[ProductController::class,'myProduct']);

 //Route::resource('products', [ProductController::class]);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
