<?php

namespace App\Repositories;

use App\Classes\Errors;
use App\Models\Merchant;

class MerchantRepository
{
    use Errors;

    private $queryMerchant;

    /**
     * 查询初始化
     * @return Merchant
     */
    public function initMerchantQuery()
    {
        $this->queryMerchant = new Merchant();
        return $this->queryMerchant;
    }

    /**
     * 排序规则
     * @param $sort
     * @return bool
     */
    public function bySort($sort)
    {
        switch ($sort) {
            case 1:
                $orderBy = 'id';                 //新店优先
                break;
            case 2:
                $orderBy = 'score';              //综合排序 （店铺）
                break;
            case 3:
                $orderBy = 'sales_count_month';  //月销量
                break;
            default:
                return false;
        }
        $this->queryMerchant = $this->queryMerchant->orderBy($orderBy, 'desc');
    }

    /**
     * 根据 分类id
     * @param $categoryId
     */
    public function byCategoryId($categoryId)
    {
        $this->queryMerchant = $this->queryMerchant->where('category_id', $categoryId);
    }

    /**
     * 根据 商家名称
     * @param $categoryId
     */
    public function byMerchantName($categoryId)
    {
        $this->queryMerchant = $this->queryMerchant->where('name', 'like', $categoryId . '%');
    }

    /**
     * 获取商家列表
     * @param $page
     * @param $pageSize
     * @return mixed
     */
    public function getMerchantData($page, $pageSize)
    {
        $merchantColumn = [
            'id',
            'user_id',
            'name',
            'category_id',
            'category_name',
            'mobile',
            'business_time',
            'business_status',
            'logo',
            'banner',
            'notice',
            'province_id',
            'province',
            'city_id',
            'city',
            'area_id',
            'area',
            'address',
            'score',
            'average_time',
            'is_shelves',
            'fee',
            'min_delivery',
            'collection_count',
            'sales_count',
            'sales_count_month',
            'sales_total',
            'click_total'
        ];
        $merchantData = $this->queryMerchant
            ->Paginate($pageSize, $merchantColumn, 'page', $page)
            ->toArray();
        $merchantData = format_page($merchantData);
        return $merchantData;
    }

}