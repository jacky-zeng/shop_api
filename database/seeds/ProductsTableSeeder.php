<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
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
                'goods_id' => 1,
                'merchant_id' => 1,
                'goods_category_id' => 1,
                'sku_name' => '碗',
                'price' => 16.00,
                'stocks' => 99
            ],
            [
                'id' => 2,
                'goods_id' => 2,
                'merchant_id' => 1,
                'goods_category_id' => 1,
                'sku_name' => '碗',
                'price' => 12.00,
                'stocks' => 99
            ],
            [
                'id' => 3,
                'goods_id' => 3,
                'merchant_id' => 1,
                'goods_category_id' => 1,
                'sku_name' => '碗',
                'price' => 12.00,
                'stocks' => 99
            ],
            [
                'id' => 4,
                'goods_id' => 4,
                'merchant_id' => 1,
                'goods_category_id' => 1,
                'sku_name' => '碗',
                'price' => 12.00,
                'stocks' => 99
            ],
            [
                'id' => 5,
                'goods_id' => 5,
                'merchant_id' => 1,
                'goods_category_id' => 1,
                'sku_name' => '碗',
                'price' => 18.00,
                'stocks' => 99
            ],
            [
                'id' => 6,
                'goods_id' => 6,
                'merchant_id' => 1,
                'goods_category_id' => 2,
                'sku_name' => '碗',
                'price' => 16.00,
                'stocks' => 99
            ],
            [
                'id' => 7,
                'goods_id' => 7,
                'merchant_id' => 1,
                'goods_category_id' => 2,
                'sku_name' => '碗',
                'price' => 12.00,
                'stocks' => 99
            ],
            [
                'id' => 8,
                'goods_id' => 8,
                'merchant_id' => 1,
                'goods_category_id' => 2,
                'sku_name' => '碗',
                'price' => 10.00,
                'stocks' => 99
            ],
            [
                'id' => 9,
                'goods_id' => 9,
                'merchant_id' => 1,
                'goods_category_id' => 2,
                'sku_name' => '碗',
                'price' => 12.00,
                'stocks' => 99
            ],
            [
                'id' => 10,
                'goods_id' => 10,
                'merchant_id' => 1,
                'goods_category_id' => 2,
                'sku_name' => '碗',
                'price' => 18.00,
                'stocks' => 99
            ],
        ];

        foreach ($list as $item) {
            $product = new Product();
            $product->id = $item['id'];
            $product->goods_id = $item['goods_id'];
            $product->merchant_id = $item['merchant_id'];
            $product->goods_category_id = $item['goods_category_id'];
            $product->sku_name = $item['sku_name'];
            $product->price = $item['price'];
            $product->stocks = $item['stocks'];
            $product->save();
        }
    }

}
