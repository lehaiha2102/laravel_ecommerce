<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('category/{slug}', [ProductController::class, 'getCategoryCollection'])->name('category');
Route::get('product/{slug}', [ProductController::class, 'getSingleProduct'])->name('product');
Route::get('cart/add/{id}', [CartController::class, 'addItemCart'])->name('addcart')->middleware('web');

Route::get('user/information/{id}', [UserController::class, 'userInfor'])->name('user.infor');
Route::post('user/sign-up', [UserController::class, 'store'])->name('user.store');
Route::post('user/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');