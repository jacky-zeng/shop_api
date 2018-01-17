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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('login', 'Api\LoginController@login')->name('login');  //登录

Route::group(['middleware' => 'api_token'], function(){
    Route::post('userInfo', 'Api\UserController@userInfo');        //查询用户信息
});
