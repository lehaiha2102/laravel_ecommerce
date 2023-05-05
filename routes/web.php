<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ManufacturerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Mail;
use App\Mail\Verify;

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
Route::get('/admin/category/index', [CategoryController::class, 'index'])->name('admin.category.index');
Route::get('/admin/category/create-category-page', [CategoryController::class, 'create'])->name('admin.category.create');
Route::post('/admin/category/create', [CategoryController::class, 'store'])->name('admin.category.store');
Route::get('/admin/category/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
Route::patch('/admin/category/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
Route::delete('/admin/category/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
Route::post('/admin/categories/change-status', [CategoryController::class, 'changeStatus'])->name('admin.categories.change-status');

// Route::get('admin/attribute/index', [AttributeController::class, 'index'])->name('admin.attribute.index');
// Route::get('/admin/attribute/create-attribute-page', [AttributeController::class, 'create'])->name('admin.attribute.create');
// Route::post('/admin/attribute/create', [AttributeController::class, 'store'])->name('admin.attribute.store');
// Route::get('/admin/attribute/edit/{id}', [AttributeController::class, 'edit'])->name('admin.attribute.edit');
// Route::patch('/admin/attribute/update/{id}', [AttributeController::class, 'update'])->name('admin.attribute.update');
// Route::delete('/admin/attribute/delete/{id}', [AttributeController::class, 'destroy'])->name('admin.attribute.destroy');

Route::get('admin/manufacturer/index', [ManufacturerController::class, 'index'])->name('admin.manufacturer.index');
Route::get('/admin/manufacturer/create-manufacturer-page', [ManufacturerController::class, 'create'])->name('admin.manufacturer.create');
Route::post('/admin/manufacturer/create', [ManufacturerController::class, 'store'])->name('admin.manufacturer.store');
Route::get('/admin/manufacturer/edit/{id}', [ManufacturerController::class, 'edit'])->name('admin.manufacturer.edit');
Route::patch('/admin/manufacturer/update/{id}', [ManufacturerController::class, 'update'])->name('admin.manufacturer.update');
Route::delete('/admin/manufacturer/delete/{id}', [ManufacturerController::class, 'destroy'])->name('admin.manufacturer.destroy');
Route::post('/admin/manufacturer/change-status', [ManufacturerController::class, 'changeStatus'])->name('admin.manufacturer.change-status');


Route::get('admin/product/index', [ProductController::class, 'index'])->name('admin.product.index');
Route::get('/admin/product/create-product-page', [ProductController::class, 'create'])->name('admin.product.create');
Route::post('/admin/product/create', [ProductController::class, 'store'])->name('admin.product.store');
Route::get('/admin/product/edit/{id}', [ProductController::class, 'edit'])->name('admin.product.edit');
Route::patch('/admin/product/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');
Route::delete('/admin/product/delete/{id}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
Route::post('/admin/product/change-status', [ProductController::class, 'changeStatus'])->name('admin.product.change-status');

Route::get('admin/role/index', [RoleController::class, 'index'])->name('admin.role.index');
Route::get('/admin/role/create-role-page', [RoleController::class, 'create'])->name('admin.role.create');
Route::post('/admin/role/create', [RoleController::class, 'store'])->name('admin.role.store');
Route::get('/admin/role/edit/{id}', [RoleController::class, 'edit'])->name('admin.role.edit');
Route::patch('/admin/role/update/{id}', [RoleController::class, 'update'])->name('admin.role.update');
Route::delete('/admin/role/delete/{id}', [RoleController::class, 'destroy'])->name('admin.role.destroy');

Route::get('/admin/user/index', [UserController::class, 'index'])->name('admin.user.index');
Route::get('/admin/user/create-user-page', [UserController::class, 'create'])->name('admin.user.create');
Route::post('/admin/user/create', [UserController::class, 'store'])->name('admin.user.store');
Route::get('/admin/user/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
Route::patch('/admin/user/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
Route::delete('/admin/user/delete/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');