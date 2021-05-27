<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Администрирование
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/',[App\Http\Controllers\Admin\BaseAdminController::class, 'index']);
    Route::get('/add',[App\Http\Controllers\Admin\PostAdminController::class, 'index'])->name('post_add');
    Route::post('/add',[App\Http\Controllers\Admin\PostAdminController::class, 'add'])->name('post_submit');
    Route::post('/edit/{id}', [App\Http\Controllers\Admin\PostAdminController::class,'edit'])->name('post_edit');
    Route::post('/edit/delete/{id}', [App\Http\Controllers\Admin\PostAdminController::class,'delete'])->name('post_delete');
});


Route::get('/', [\App\Http\Controllers\CatalogController::class,'index'])->name('welcome');
Route::get('/{type}/{id}', [\App\Http\Controllers\CatalogController::class,'catalog_item'])->name('catalog_item');


//Оплата товара
Route::prefix('/cart/order/blank')->group(function () {
    Route::get('/',[App\Http\Controllers\PaymentController::class, 'index'])->name('payment_blank');
    Route::post('/payment',[App\Http\Controllers\PaymentController::class, 'pay'])->name('start_payment');
});

//Корзина
Route::prefix('cart')->group(function () {
    Route::get('/',[App\Http\Controllers\CartController::class, 'index'])->name('cart_show');
    Route::post('/status',[App\Http\Controllers\CartController::class, 'getStatus']);//axios
    Route::post('/add',[App\Http\Controllers\CartController::class, 'add']);//axios
    Route::post('/remove',[App\Http\Controllers\CartController::class, 'remove']);//axios
    Route::post('/increase',[App\Http\Controllers\CartController::class, 'increase']);//axios
    Route::post('/decrease',[App\Http\Controllers\CartController::class, 'decrease']);//axios
    Route::post('/get_products',[App\Http\Controllers\CartController::class, 'getProducts']);//axios
});

//Фильтр на главной странице каталога
Route::post('/catalog/filter',[App\Http\Controllers\CatalogController::class, 'typeFilter']);
Route::get('/catalog/filter/{type}', [\App\Http\Controllers\CatalogController::class,'typeFilter'])->name('type_filter');
