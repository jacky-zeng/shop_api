<?php namespace app\Http\Controllers\Api;

use App\Classes\Code;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;

class UserController extends Controller
{

    //获取用户信息
    public function userInfo(Request $request)
    {
        $params = $request->all();
        $user_id = array_get($params, 'user_info.user_id');
        return $this->successResponse(['user_id' => $user_id]);
    }

    //登录接口
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|between:6,32',
        ]);
        if ($validator->fails()) {
            $request->request->add([
                'errors' => $validator->errors()->toArray(),
                'code' => Code::UNAUTHORIZED_ERROR,
            ]);
            return $this->sendFailedLoginResponse($request);
        }
        return $this->sendLoginResponse($request);
    }

    /***************** 认证代码   begin *************************/
    // 登录用户名标示为name字段
    public function username()
    {
        return 'username'; //填充到credentials函数内
    }

    use  AuthenticatesUsers;

    //调用认证接口获取授权码
    protected function authenticateClient(Request $request)
    {
        $credentials = $this->credentials($request);
        $data = $request->all();
        $request->request->add([
            'grant_type' => $data['grant_type'],
            'client_id' => $data['client_id'],
            'client_secret' => $data['client_secret'],
            'username' => $credentials['username'],
            'password' => $credentials['password'],
            'scope' => ''
        ]);
        $proxy = Request::create(
            'oauth/token',
            'POST'
        );
        $response = \Route::dispatch($proxy);
        $data = json_decode((string)$response->getContent(), true);
        if(array_get($data, 'error') || !array_get($data, 'access_token')){
            return $this->errorResponse(array_get($data, 'error'), Code::UNAUTHORIZED_ERROR);
        }
        unset($data['refresh_token']);  //暂时不使用 refresh_token
        return $this->successResponse($data, '登录成功');
    }

    //以下为重写部分
    protected function authenticated(Request $request)
    {
        return $this->authenticateClient($request);
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        return $this->authenticated($request);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $msg = current($request['errors']);
        $code = $request['code'];
        return $this->errorResponse($msg, $code);
    }
    /***************** 认证代码   end *************************/

}