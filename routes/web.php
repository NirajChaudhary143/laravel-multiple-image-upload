<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\TempImageController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/products/create',[ProductController::class,'index'])->name('create');
Route::post('/products',[ProductController::class,'store'])->name('products.store');
Route::get('/products/list',[ProductController::class,'list'])->name('products.list');
Route::get('/product/edit/{id}',[ProductController::class,'edit'])->name('products.edit');
Route::post('/product/edit/{id}',[ProductController::class,'update'])->name('products.update');
Route::post('/product/edit',[ProductImageController::class,'store'])->name('products.images.store');


Route::post('/temp-images',[TempImageController::class,'store'])->name('temp-images.create');
