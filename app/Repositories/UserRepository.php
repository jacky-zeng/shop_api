<?php

namespace App\Repositories;

use App\Classes\Errors;
use App\Models\User;
use DB;
use Laravel\Passport\Token;

class UserRepository
{
    use Errors;

    /**
     * 获取用户信息
     * @param $user_id
     * @return mixed
     */
    public function userInfo($user_id)
    {
        $userData = User::where('id', $user_id)
            ->first(['id', 'name', 'email'])
            ->toArray();
        return $userData;
    }

    /**
     * 用户注册
     * @param $params
     * @return bool
     */
    public function createUser($params)
    {
        $username = $params['username'];
        $email = $params['email'];
        $password = $params['password'];
        $confirm_password = $params['confirm_password'];
        if ($password !== $confirm_password) {
            $this->error('密码不一致');
            return false;
        }
        $userData = User::where('name', $username)->first();
        if ($userData) {
            $this->error('该用户名已被使用');
            return false;
        }
        $userData = User::where('email', $email)->first();
        if ($userData) {
            $this->error('该邮箱名已被使用');
            return false;
        }
        $userMdl = User::create([
            'name' => $username,
            'password' => bcrypt($password),
            'email' => $email
        ]);
        if(count($userMdl)){
            return true;
        }
        return false;
    }

    /**
     * 用户退出登录
     * @param $user_id
     */
    public function logout($user_id)
    {
        $tokenIds = Token::where('user_id', $user_id)->pluck('id');
        DB::table('oauth_refresh_tokens')->whereIn('access_token_id', $tokenIds)->delete();
        Token::where('user_id', $user_id)->delete();
    }

}