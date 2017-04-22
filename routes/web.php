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




Route::get('/login', function (){
    return view('login');
})->name('loginPage');
Route::get('/', 'IndexController@show')->name('home');

Route::post('/login', 'UserController@login');

Route::post('/Article', 'ArticleController@upload');

Route::post('/ArticleEdit', 'ArticleController@edit');

Route::post('/ArticleState', 'ArticleController@editState');


