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


Route::get('/',function(){
   return view('index');
});

Route::get('/background/login', function (){
    return view('login');
})->name('loginPage');
Route::get('/background', 'IndexController@show')->name('home');

Route::post('/background/login', 'UserController@login');
Route::get('/background/logout', 'IndexController@logout')->name('logout');

Route::post('/background/Article', 'ArticleController@upload');

Route::post('/background/ArticleEdit', 'ArticleController@edit');

Route::post('/background/ArticleState', 'ArticleController@editState');


