<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\LikeController;

use App\Http\Controllers\TestController;
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

// Route::resource('user', TestController::class);
Route::post("register", [AuthorController::class, "register"]);
Route::post("login", [AuthorController::class, "login"]);
// Route::get("show_all_product", [ProductController::class, "show"]);

Route::get("index",[ProductController::class,"index"]);

// Route::group(["middleware" => ["auth:api"]], function () {
//     Route::get("profile", [AuthorController::class, "profile"]);
//     Route::post("logout", [AuthorController::class, "logout"]);
//     Route::get("liked/{id}", [ProductController::class, "like"]);
//     Route::get("author-product", [ProductController::class, "authorProduct"]);
//     Route::get("search", [ProductController::class, "search"]);
//     Route::get("sort/{name}", [ProductController::class, "sorting"]);

//     Route::prefix('products')->group(function () {
//         Route::get('index', [ProductController::class, 'index']);
//         Route::post('/', [ProductController::class, 'store']);
//         Route::get('/{product_id}', [ProductController::class, 'show']);
//         Route::put('/{product}', [ProductController::class, 'update']);
//         Route::delete('/{product}', [ProductController::class, 'destroy']);

//         Route::prefix("/{product_id}/comments")->group(function () {
//             Route::get('/', [CommentController::class, 'index']);
//             Route::post('/', [CommentController::class, 'store']);
//             // Route::put('/{comment}', [CommentController::class, 'update']);
//             // Route::delete('/{comment}', [CommentController::class, 'destroy']);
//         });
//         Route::prefix("/{product_id}/likes")->group(function () {
//             Route::get('/', [LikeController::class, 'index']);
//             Route::post('/', [LikeController::class, 'store']);
//             // Route::put('/{comment}', [CommentController::class, 'update']);
//             // Route::delete('/{comment}', [CommentController::class, 'destroy']);
//         });
//     });

//     // Route::post("create_pruduct", [ProductController::class, "store"]);
//     // Route::get("single-product/{id}", [ProductController::class, "index"]);
//     // Route::post("update-product/{id}", [ProductController::class, "update"]);
//     // Route::delete("delete-product/{id}", [ProductController::class, "destroy"]);
//     Route::post("/create_category", [CategoryController::class, "store"]);
// });
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
