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
    Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
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
    Route::post('register',    'App\Http\Controllers\Store\RegisterController@create');
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
    Route::get('home',      'App\Http\Controllers\Store\HomeController@index')->name('store.home');
});