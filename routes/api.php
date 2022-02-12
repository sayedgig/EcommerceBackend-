<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendController;

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
Route::get('edit-product/{id}',[ProductController::class,'edit']);
Route::put('update-product/{id}',[ProductController::class,'update']);

//frontend
Route::get('get-category',[FrontendController::class,'category']);
Route::get('fetch-products/{slug}',[FrontendController::class,'product']);
Route::get('view-product-details/{category_slug}/{product_slug}',[FrontendController::class,'viewProduct']);

Route::post('add-to-cart',[CartController::class,'addtocart']);
Route::get('cart',[CartController::class,'viewcart']);
Route::put('update-quantity/{cart_id}/{scope}',[CartController::class,'updatequantity']);
Route::delete('delete-cartitem/{cart_id}',[CartController::class,'deletecarditem']);



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
