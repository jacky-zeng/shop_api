<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //营业状态 1-营业中 2-已打烊
    const BUSINESS_STATUS_YES = 1;
    const BUSINESS_STATUS_NO  = 0;
    public static $_BUSINESS_STATUS = [
        self::BUSINESS_STATUS_YES => '营业中',
        self::BUSINESS_STATUS_NO  => '已打烊'
    ];

    //上下架状态  默认1已上架  0已下架
    const IS_SHELVES_YES = 1;
    const IS_SHELVES_NO  = 0;

}
