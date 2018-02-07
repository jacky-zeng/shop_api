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

/**用户端路由**/
Route::group([
    'middleware' => ['query_log'],
    'namespace'  => 'Api'
], function(){
    Route::post('getCategories', 'User\CategoryController@getCategories');                            //获取首页全部分类
    Route::post('getMerchants', 'User\MerchantController@getMerchants');                              //获取商家列表
    Route::post('getGoodsCats', 'User\GoodsCatController@getGoodsCats');                              //获取商家商品分类
    Route::post('getGoods', 'User\GoodsController@getGoods');                                         //获取商家所有商品
});

Route::group([
    'middleware' => ['query_log', 'api_token'],
    'namespace'  => 'Api'
], function(){
    Route::post('getAddresses', 'User\AddressController@getAddresses');                               //获取用户地址列表
    Route::post('getAddressDetail', 'User\AddressController@getAddressDetail');                       //获取用户地址详情
    Route::post('addAddress', 'User\AddressController@addAddress');                                   //新增收货地址
    Route::post('editAddress', 'User\AddressController@editAddress');                                 //编辑收货地址
    Route::post('delAddress', 'User\AddressController@delAddress');                                   //删除收货地址
    Route::post('createOrder', 'User\OrderController@createOrder');                                   //创建订单
    Route::post('getOrders', 'User\OrderController@getOrders');                                       //获取用户订单列表
    Route::post('getOrderDetail', 'User\OrderController@getOrderDetail');                             //获取用户订单详情

});
