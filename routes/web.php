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

Route::get('/', function(){
    return !session('user') ? view('home') : view('login');
});

Route::post('/', 'UserController@login');

Route::get('/Register', function(){
    return view('register');
});

Route::post('/Register', 'UserController@register');

Route::group(['middleware'=>'article', 'prefix'=>'Article'], function () {
    Route::post('/', 'ArticleController@upload');
    Route::post('/delete', 'ArticleController@delete');
    Route::post('/recover', 'ArticleController@recover');
});

