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

//todo（后续需要删除） 未便于测试 暂时允许跨域访问
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE');

Route::group(['middleware' => ['query_log']], function(){
    Route::post('register', 'Api\UserController@register');         //注册
    Route::post('login', 'Api\UserController@login');               //登录
});

Route::group(['middleware' => ['query_log', 'api_token']], function(){
    Route::post('logout', 'Api\UserController@logout');             //退出登录
    Route::post('userInfo', 'Api\UserController@userInfo');         //查询用户信息
});
