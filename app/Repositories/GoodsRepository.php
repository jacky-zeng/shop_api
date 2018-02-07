<?php

namespace App\Repositories;

use App\Classes\Errors;
use App\Models\Good;

class GoodsRepository
{
    use Errors;

    /**
     * 获取商家所有商品  （暂时认为是外卖商品 不分页）
     * @param $merchantId
     * @return mixed
     */
    public function getGoods($merchantId)
    {
        $goodsColumn = [
            'id',
            //'merchant_id',
            'goods_category_id',
            'name',
            'goods_image',
            'is_sku',
            'sku_detail',
            'description',
            'unit',
            'sales_count',
            'sales_count_month',
            //'shelves_status',
            //'sale_status',
            //'is_del'
        ];
        $productColumn = [
            'id',
            'goods_id',
            //'merchant_id',
            'goods_category_id',
            'sku_name',
            'price',
            'stocks'
        ];
        $goodsCatData = Good::with(['products' => function ($productQuery) use ($productColumn) {
            $productQuery->select($productColumn);
        }])->where([
            'merchant_id'    => $merchantId,
            'shelves_status' => Good::SHELVES_STATUS_YES,
            'sale_status'    => Good::SALE_STATUS_YES,
            'is_del'         => Good::IS_DEL_NO
        ])->get($goodsColumn)
            ->toArray();
        return $goodsCatData;
    }

}