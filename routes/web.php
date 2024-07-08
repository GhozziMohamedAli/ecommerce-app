<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

Route::get('/', [HomeController::class,'index']);

Route::prefix('admin')->group(function(){
    Route::get('/dashboard',[DashboardController::Class,'index']);
    //Product Routes
    Route::resources([
        'products' => ProductController::class,
        'category' => CategoryController::class
        ]);
    
});
//Sub_routes
Route::prefix('/products')->group(function(){
    Route::post('/listDelete',[ProductController::class,'listDelete']);
    Route::post('/filter',[ProductController::class,'Filter']);
});


Route::get('/loadCategories',[ProductController::class,'load_categories']);
Route::prefix('/category')->group(function(){
    Route::get('/category_has_products/{id}',[CategoryController::class,'category_has_products']);
    
});

Route::prefix('/shop')->group(function(){
    Route::get('/',[ShopController::class,'index'])->name('shop');
    Route::post('/cart',[ShopController::class,'cart']);
    Route::get('/checkout',[ShopController::class,'checkout']);
    Route::post('/charge', [App\Http\Controllers\ShopController::class, 'pay'])->middleware(['web', 'auth']);;
});
Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

