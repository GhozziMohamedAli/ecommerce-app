<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CategoryController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home');
});

Route::resources([
'products' => ProductController::class,
'category' => CategoryController::class
]);

Route::get('/dash', function () {
    return view('admin.dashboard');
});


Route::prefix('/products')->group(function(){
    Route::post('/listDelete',[ProductController::class,'listDelete']);
    Route::post('/filter',[ProductController::class,'Filter']);
});

Route::get('/loadCategories',[ProductController::class,'load_categories']);
Route::prefix('/category')->group(function(){
    Route::get('/category_has_products/{id}',[CategoryController::class,'category_has_products']);
    
});

Route::prefix('/shop')->group(function(){
    Route::get('/',[ShopController::class,'index']);
});