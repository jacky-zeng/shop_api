<?php

namespace App\Repositories;

use App\Classes\Errors;
use App\Models\Good;
use Redis;

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

    /**
     * 设置抢购商品及抢购库存
     * @param $params
     * @return bool
     */
    public function setRushBuyStocks($params)
    {
        $stocks   = $params['stocks'];
        Redis::del('list', 'users', 'is_high');  //删除 防止脏数据
        Redis::set('user_id', 0);                //从0开始
        $rs     = Redis::set('stocks', $stocks);
        $rsPush = Redis::pipeline(function ($pipe) use ($stocks) {
            for ($i = 1; $i <= $stocks; $i++) {
                $pipe->lpush('list', 'stock_'.$i);
            }
        });

        if (! $rs || ! $rsPush) {
            return false;
        }

        return true;
    }

    /**
     * 开始抢购
     * @return bool
     */
    public function createRob()
    {
        $user_id = date('YmdHiss', time()).'__'.Redis::incr('user_id');
        $len     = Redis::llen('list');
        sleep(1);
        if ($len == 0) {
            $this->error('已经抢光了');
            return false;
        } else {
            $rsPop = Redis::lpop('list');
            if (! $rsPop) {
                Redis::set('is_high', 'yes');
                $this->error('已经抢光了(超高并发)');
                return false;
            }
            $result = Redis::lpush('users', $user_id);
            if (! $result) {
                $this->error('失败了');
                return false;
            }
            return $user_id;
        }
    }

    /**
     * 开始抢购(不支持高并发)
     * @return bool
     */
    public function createBadRob()
    {
        $num      = Redis::get('stocks');
        $user_id  = date('YmdHiss', time()).'__'.Redis::incr('user_id');
        $len_user = Redis::llen('users');
        sleep(1);
        if ($len_user >= $num) {
            $this->error('已经抢光了');
            return false;
        }

        $is_high = '';
        if (Redis::llen('users') >= $num) {
            $is_high = '_is_high';
            Redis::set('is_high', 'yes');
        }

        $result = Redis::lpush('users', $user_id.$is_high);  //把抢到的用户存入到列表中
        if (! $result) {
            $this->error('失败了');
            return false;
        }

        return true;
    }

}