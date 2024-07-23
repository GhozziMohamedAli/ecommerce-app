<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\IsAdmin;


Route::get('/', [HomeController::class,'index']);

Route::prefix('admin')->middleware(['auth',IsAdmin::class])->group(function(){
    Route::get('/dashboard',[DashboardController::Class,'index']);
    //Product Routes
    Route::resources([
        'products' => ProductController::class,
        'category' => CategoryController::class
        ]);
    
});

Route::prefix('user')->group(function(){
    Route::get('/dashboard',[UserController::class,'index']);
    Route::get('/order',[UserController::class,'getOrder']);
});
//Sub_routes
Route::middleware(['auth',IsAdmin::class])->prefix('/products')->group(function(){
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
    Route::post('/charge', [App\Http\Controllers\ShopController::class, 'pay'])->middleware(['web', 'auth']);
    Route::get('/charge_later/{id}', [App\Http\Controllers\ShopController::class, 'pay_later'])->middleware(['web', 'auth']);
    Route::get('/success', [App\Http\Controllers\ShopController::class, 'checkout_success'])->name('checkout-success')->middleware(['web', 'auth']);
});
Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('chat')->group(function(){
    Route::get('/', [App\Http\Controllers\ChatsController::class, 'index']);
    Route::post('/send', [App\Http\Controllers\ChatsController::class, 'sendMessage']);

    Route::get('/messages', [App\Http\Controllers\ChatsController::class, 'fetchMessages']);
    
});

