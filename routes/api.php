<?php

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

Route::group(['middleware' => ['query_log']], function(){
    Route::any('login', 'Api\LoginController@login')->name('login');  //登录
});

Route::group(['middleware' => ['query_log', 'api_token']], function(){
    Route::post('userInfo', 'Api\UserController@userInfo');        //查询用户信息
});
