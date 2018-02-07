<?php

use Illuminate\Database\Seeder;
use App\Models\Good;

class GoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = [
            [
                'id' => 1,
                'merchant_id' => 1,
                'goods_category_id' => 1,
                'name' => '红烧牛肉面',
                'goods_image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/11/1.jpg',
                'is_sku' => 0,
                'sku_detail' => '[{"price":16.00,"stocks":99,"spec_name":"\u5c0f\u4efd"}]',
                'description' => '【使用汤面分离进行配送】 为防止面糊掉,进行了分离',
                'unit' => '碗',
                'sales_count' => 16,
                'sales_count_month' => 650,
                'shelves_status' => 1,
                'sale_status' => 1,
                'is_del' => 0
            ],
            [
                'id' => 2,
                'merchant_id' => 1,
                'goods_category_id' => 1,
                'name' => '(汤面)碗杂小面',
                'goods_image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/11/2.jpg',
                'is_sku' => 0,
                'sku_detail' => '[{"price":12.00,"stocks":99,"spec_name":"\u5c0f\u4efd"}]',
                'description' => '【使用汤面分离进行配送】 为防止面糊掉,进行了分离',
                'unit' => '碗',
                'sales_count' => 26,
                'sales_count_month' => 950,
                'shelves_status' => 1,
                'sale_status' => 1,
                'is_del' => 0
            ],
            [
                'id' => 3,
                'merchant_id' => 1,
                'goods_category_id' => 1,
                'name' => '(拌面)碗杂小面',
                'goods_image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/11/2.jpg',
                'is_sku' => 0,
                'sku_detail' => '[{"price":12.00,"stocks":99,"spec_name":"\u5c0f\u4efd"}]',
                'description' => '【拌面将会赠送小碗紫菜蛋汤】 尽情享用吧',
                'unit' => '碗',
                'sales_count' => 56,
                'sales_count_month' => 1550,
                'shelves_status' => 1,
                'sale_status' => 1,
                'is_del' => 0
            ],
            [
                'id' => 4,
                'merchant_id' => 1,
                'goods_category_id' => 1,
                'name' => '(拌面)碗杂小面2',
                'goods_image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/11/2.jpg',
                'is_sku' => 0,
                'sku_detail' => '[{"price":12.00,"stocks":99,"spec_name":"\u5c0f\u4efd"}]',
                'description' => '',
                'unit' => '碗',
                'sales_count' => 56,
                'sales_count_month' => 1550,
                'shelves_status' => 1,
                'sale_status' => 1,
                'is_del' => 0
            ],
            [
                'id' => 5,
                'merchant_id' => 1,
                'goods_category_id' => 1,
                'name' => '红烧牛肉面2',
                'goods_image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/11/1.jpg',
                'is_sku' => 0,
                'sku_detail' => '[{"price":18.00,"stocks":99,"spec_name":"\u5c0f\u4efd"}]',
                'description' => '【使用汤面分离进行配送】 为防止面糊掉,进行了分离',
                'unit' => '碗',
                'sales_count' => 16,
                'sales_count_month' => 650,
                'shelves_status' => 1,
                'sale_status' => 1,
                'is_del' => 0
            ],
            [
                'id' => 6,
                'merchant_id' => 1,
                'goods_category_id' => 2,
                'name' => '红烧牛肉面',
                'goods_image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/11/1.jpg',
                'is_sku' => 0,
                'sku_detail' => '[{"price":16.00,"stocks":99,"spec_name":"\u5c0f\u4efd"}]',
                'description' => '【使用汤面分离进行配送】 为防止面糊掉,进行了分离',
                'unit' => '碗',
                'sales_count' => 16,
                'sales_count_month' => 650,
                'shelves_status' => 1,
                'sale_status' => 1,
                'is_del' => 0
            ],
            [
                'id' => 7,
                'merchant_id' => 1,
                'goods_category_id' => 2,
                'name' => '(汤面)碗杂小面',
                'goods_image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/11/2.jpg',
                'is_sku' => 0,
                'sku_detail' => '[{"price":12.00,"stocks":99,"spec_name":"\u5c0f\u4efd"}]',
                'description' => '【使用汤面分离进行配送】 为防止面糊掉,进行了分离',
                'unit' => '碗',
                'sales_count' => 26,
                'sales_count_month' => 950,
                'shelves_status' => 1,
                'sale_status' => 1,
                'is_del' => 0
            ],
            [
                'id' => 8,
                'merchant_id' => 1,
                'goods_category_id' => 2,
                'name' => '(拌面)碗杂小面',
                'goods_image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/11/2.jpg',
                'is_sku' => 0,
                'sku_detail' => '[{"price":10.00,"stocks":99,"spec_name":"\u5c0f\u4efd"}]',
                'description' => '【拌面将会赠送小碗紫菜蛋汤】 尽情享用吧',
                'unit' => '碗',
                'sales_count' => 56,
                'sales_count_month' => 1550,
                'shelves_status' => 1,
                'sale_status' => 1,
                'is_del' => 0
            ],
            [
                'id' => 9,
                'merchant_id' => 1,
                'goods_category_id' => 2,
                'name' => '(拌面)碗杂小面2',
                'goods_image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/11/2.jpg',
                'is_sku' => 0,
                'sku_detail' => '[{"price":12.00,"stocks":99,"spec_name":"\u5c0f\u4efd"}]',
                'description' => '',
                'unit' => '碗',
                'sales_count' => 56,
                'sales_count_month' => 1550,
                'shelves_status' => 1,
                'sale_status' => 1,
                'is_del' => 0
            ],
            [
                'id' => 10,
                'merchant_id' => 1,
                'goods_category_id' => 2,
                'name' => '红烧牛肉面2',
                'goods_image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/11/1.jpg',
                'is_sku' => 0,
                'sku_detail' => '[{"price":18.00,"stocks":99,"spec_name":"\u5c0f\u4efd"}]',
                'description' => '【使用汤面分离进行配送】 为防止面糊掉,进行了分离',
                'unit' => '碗',
                'sales_count' => 16,
                'sales_count_month' => 650,
                'shelves_status' => 1,
                'sale_status' => 1,
                'is_del' => 0
            ],
        ];

        foreach ($list as $item) {
            $good = new Good();
            $good->id = $item['id'];
            $good->merchant_id = $item['merchant_id'];
            $good->goods_category_id = $item['goods_category_id'];
            $good->name = $item['name'];
            $good->goods_image = $item['goods_image'];
            $good->is_sku = $item['is_sku'];
            $good->sku_detail = $item['sku_detail'];
            $good->description = $item['description'];
            $good->unit = $item['unit'];
            $good->sales_count = $item['sales_count'];
            $good->sales_count_month = $item['sales_count_month'];
            $good->shelves_status = $item['shelves_status'];
            $good->sale_status = $item['sale_status'];
            $good->is_del = $item['is_del'];
            $good->save();
        }
    }

}
