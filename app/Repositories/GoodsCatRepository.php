<?php

namespace App\Repositories;

use App\Classes\Errors;
use App\Models\GoodsCat;

class GoodsCatRepository
{
    use Errors;

    /**
     * 获取商家所有商品分类
     * @param $merchantId
     * @return mixed
     */
    public function getGoodsCats($merchantId)
    {
        $goodsCatColumn = ['id', 'name'];
        $goodsCatData = GoodsCat::where([
            'merchant_id' => $merchantId,
            'is_del'      => GoodsCat::IS_DEL_NO
        ])->orderBy('sort')
            ->get($goodsCatColumn)
            ->toArray();
        return $goodsCatData;
    }

}