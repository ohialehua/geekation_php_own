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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
/*
|--------------------------------------------------------------------------
| 1) User 認証不要
|--------------------------------------------------------------------------
*/
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
/*
|--------------------------------------------------------------------------
| 2) User ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth:user'], function() {
    Route::get('home', 'App\Http\Controllers\Auth\HomeController@show')->name('home');
    Route::get('user/index',      'App\Http\Controllers\Auth\UserController@index')->name('user.index');
    Route::get('user/{id}',      'App\Http\Controllers\Auth\UserController@show')->name('user.show');
    Route::get('user/edit/{id}',      'App\Http\Controllers\Auth\UserController@edit')->name('user.edit');
    Route::post('user/edit/{id}',      'App\Http\Controllers\Auth\UserController@update')->name('user.update');
    Route::get('user/store/index',      'App\Http\Controllers\Auth\StoreController@index')->name('user.store.index');
    Route::get('user/store/{id}',      'App\Http\Controllers\Auth\StoreController@show')->name('user.store.show');
    Route::get('user/delivery/index',      'App\Http\Controllers\Auth\DeliveryController@index')->name('user.delivery.index');
    Route::post('user/delivery/create',      'App\Http\Controllers\Auth\DeliveryController@create')->name('user.delivery.create');
    Route::get('user/delivery/edit/{id}',      'App\Http\Controllers\Auth\DeliveryController@edit')->name('user.delivery.edit');
    Route::post('user/delivery/edit/{id}',      'App\Http\Controllers\Auth\DeliveryController@update')->name('user.delivery.update');
    Route::post('user/delivery/delete/{id}',      'App\Http\Controllers\Auth\DeliveryController@destroy')->name('user.delivery.destroy');
    Route::get('user/item/index',                  'App\Http\Controllers\Auth\ItemController@index')->name('user.item.index');
    Route::get('user/item/{id}',                    'App\Http\Controllers\Auth\ItemController@show')->name('user.item.show');
});

/*
|--------------------------------------------------------------------------
| 3) Admin 認証不要
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin'], function() {
    Route::get('login',     'App\Http\Controllers\Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login',    'App\Http\Controllers\Admin\LoginController@login');
});

/*
|--------------------------------------------------------------------------
| 4) Admin ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
    Route::post('logout',   'App\Http\Controllers\Admin\LoginController@logout')->name('admin.logout');
    Route::get('home',      'App\Http\Controllers\Admin\HomeController@index')->name('admin.home');
});
/*
|--------------------------------------------------------------------------
| 5) Store 認証不要
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'store'], function() {
    Route::get('register',     'App\Http\Controllers\Store\RegisterController@showRegisterForm')->name('store.register');
    Route::post('register',    'App\Http\Controllers\Store\RegisterController@register');
    Route::get('login',     'App\Http\Controllers\Store\LoginController@showLoginForm')->name('store.login');
    Route::post('login',    'App\Http\Controllers\Store\LoginController@login');
});

/*
|--------------------------------------------------------------------------
| 6) Store ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'store', 'middleware' => 'auth:store'], function() {
    Route::post('logout',   'App\Http\Controllers\Store\LoginController@logout')->name('store.logout');
    Route::get('home',      'App\Http\Controllers\Store\HomeController@show')->name('store.home');
    Route::get('edit',      'App\Http\Controllers\Store\StoreController@edit')->name('store.edit');
    Route::post('edit',      'App\Http\Controllers\Store\StoreController@update')->name('store.update');
    Route::get('item/new',    'App\Http\Controllers\Store\ItemController@new')->name('store.item.new');
    Route::post('item/create','App\Http\Controllers\Store\ItemController@create')->name('store.item.create');
    Route::get('item/{id}/edit',    'App\Http\Controllers\Store\ItemController@edit')->name('store.item.edit');
    Route::post('item/{id}/edit',      'App\Http\Controllers\Store\ItemController@update')->name('store.item.update');
    Route::post('item/{id}/delete',      'App\Http\Controllers\Store\ItemController@destroy')->name('store.item.destroy');
});