<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

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

//Route::get('/book', [BookController::class,'index']);
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);


Route::middleware('auth:sanctum')->get('/book', [BookController::class,'index']);

Route::post('store-product',[ProductController::class,'store']);
Route::get('all-category',[CategoryController::class,'allCategory']);
Route::get('view-product',[ProductController::class,'index']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout',[AuthController::class,'logout']);
    Route::get('checkAuth',[AuthController::class,'isApiAdmin']);
   //Category
    Route::post('store-category',[CategoryController::class,'store']);
    Route::get('view-category',[CategoryController::class,'index']);
    Route::get('edit-category/{id}',[CategoryController::class,'edit']);
    Route::put('update-category/{id}',[CategoryController::class,'update']);
    Route::delete('delete-category/{id}',[CategoryController::class,'destroy']);
    //product 
   
    
});

// Route::middleware('auth:sanctum','isApiAdmin')->group(function () {
//     Route::get('checkAuth', function () {
//         return response()->json([
//             'message' => 'you are in',
//             'status' => 200
//         ],200);
//     });
// });
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
