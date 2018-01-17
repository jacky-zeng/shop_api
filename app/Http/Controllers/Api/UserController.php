<?php namespace app\Http\Controllers\Api;

use App\Classes\Code;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

    //获取用户信息
    public function userInfo(Request $request)
    {
        $params = $request->all();
        $user_id = array_get($params, 'user_info.user_id');
        return $this->successResponse(['user_id' => $user_id]);
    }

}