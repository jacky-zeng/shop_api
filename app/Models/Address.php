<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //性别
    const SEX_UN_KNOW = 0;   //未知
    const SEX_MAN     = 1;   //男
    const SEX_WOMAN   = 2;   //女
    public static $_SEX = [
        self::SEX_UN_KNOW => '未知',
        self::SEX_MAN     => '男',
        self::SEX_WOMAN   => '女'
    ];

    //标签
    const TAG_UN_KNOW  = 0;   //未知
    const TAG_HOME     = 1;   //家
    const TAG_COMPANY  = 2;   //公司
    const TAG_SCHOOL   = 3;   //学校
    public static $_TAG = [
        self::TAG_UN_KNOW  => '未知',
        self::TAG_HOME     => '家',
        self::TAG_COMPANY  => '公司',
        self::TAG_SCHOOL   => '学校'
    ];

}
