<?php

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

Route::get('/', 'ProductController@index');
Route::get('/products/{id}/shared-url', 'ProductController@sharedUrl');
Route::post('/products/check-product', 'ProductController@checkProduct');
Route::get('signup', 'AuthController@indexSignup');
Route::post('signup', 'AuthController@signup');
Route::get('login', 'AuthController@indexLogin');
Route::post('admin/tools/update-product-price', 'admin\ToolController@updateProductPrice');
Route::post('admin/tools/create-product-redis', 'admin\ToolController@createProductRedis');
Route::post('admin/orders/{id}/delivery', 'admin\OrderController@delivery');
Route::post('login', 'AuthController@login');
Route::resource('/admin/products', 'admin\ProductController');
// Route::resource('carts', 'CartController');
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('user', 'AuthController@user');
    Route::get('logout', 'AuthController@logout');
    Route::post('carts/checkout', 'CartController@checkout');
    Route::resource('carts', 'CartController');
    Route::resource('cart-items', 'CartItemController');
});