<?php

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


//后台
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
    Route::group(['middleware' => 'auth:admin'], function() {
        //这里面写需要登录的路由
        Route::get('/','IndexController@index')->middleware('permission');
        Route::get('index/index','IndexController@index')->middleware('permission');
        Route::resource('admin', 'AdminController')->middleware('permission');
        Route::patch('admin/enable/{id}', 'AdminController@enable')->middleware('permission');
        Route::patch('admin/disable/{id}', 'AdminController@disable')->middleware('permission');
        Route::resource('role', 'RoleController')->middleware('permission');
        Route::patch('role/enable/{id}', 'RoleController@enable')->middleware('permission');
        Route::patch('role/disable/{id}', 'RoleController@disable')->middleware('permission');
        Route::resource('node', 'NodeController')->middleware('permission');
    });
    //这下面写不需要登录的路由
    Route::get('login','Auth\LoginController@showLoginForm');
    Route::post('login','Auth\LoginController@login');
    Route::post('logout','Auth\LoginController@logout');
    //Auth::routes();
});





Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
