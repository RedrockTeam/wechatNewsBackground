<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group([ 'prefix'=>'ArticleOperate'], function () {
    Route::post('/delete', 'ArticleController@delete');
    Route::post('/recover', 'ArticleController@recover');
});
Route::group(['prefix'=>'Article', 'middleware'=>'cors'],function(){
    Route::post('/','ArticleController@show');
    Route::get('/','ArticleController@show');
    Route::get('{type}', 'ArticleController@show');
    Route::post('{type}', 'ArticleController@show');
});


Route::get('/Photo/{name}', function($name){
    if( Storage::disk('photo')->exists($name))
        return response()->file(Storage::disk('photo')->url($name));
    else
        return view('errors.errors');
})->name('showPicture');

//Route::post('/User', 'UserController@register');
