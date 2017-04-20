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



Route::get('/', function(){
    return session('user') ? redirect()->action('IndexController@show') : view('login');
});
Route::get('/home', 'IndexController@show');
Route::post('/', 'UserController@login');

Route::post('/Article', 'ArticleController@upload');


