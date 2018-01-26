<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    //是否有规格 1-有 0-没有，默认 0
    const IS_SKU_YES = 1;
    const IS_SKU_NO  = 0;

    //是否必选商品   1-是  0-否 默认 0
    const IS_MUST_CHECK_YES = 1;
    const IS_MUST_CHECK_NO  = 0;

    //上架状态 1-上架 0-下架 默认 1（后台管理）
    const SHELVES_STATUS_YES = 1;
    const SHELVES_STATUS_NO  = 0;

    //售卖状态 1-在售 2-停售 默认 1（商家管理）
    const SALE_STATUS_YES = 1;
    const SALE_STATUS_NO  = 0;

    //是否删除，1-是 0-否 默认 0
    const IS_DEL_YES = 1;
    const IS_DEL_NO  = 0;

}
