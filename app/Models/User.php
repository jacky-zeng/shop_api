<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;  //用于检查已认证用户的令牌和使用作用域。

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 自定义用Passport授权登录：用户名+密码  使用name字段作为用户名
     * @param $username
     * @return mixed
     */
    public function findForPassport($username)
    {
        return self::where('name', $username)->first();
    }

}
