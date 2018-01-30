<?php

use Illuminate\Database\Seeder;
use App\Models\GoodsCat;

class GoodsCatTableSeeder extends Seeder
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
                'name' => '热销',
                'sort' => 1
            ],
            [
                'id' => 2,
                'merchant_id' => 1,
                'name' => '优惠',
                'sort' => 2
            ],
            [
                'id' => 3,
                'merchant_id' => 1,
                'name' => '家常小炒',
                'sort' => 3
            ],
            [
                'id' => 4,
                'merchant_id' => 1,
                'name' => '爽口凉菜',
                'sort' => 4
            ],
            [
                'id' => 5,
                'merchant_id' => 1,
                'name' => '田园时蔬',
                'sort' => 5
            ],
            [
                'id' => 6,
                'merchant_id' => 1,
                'name' => '主食点心',
                'sort' => 6
            ],
            [
                'id' => 7,
                'merchant_id' => 1,
                'name' => '饮料类',
                'sort' => 7
            ],
            [
                'id' => 8,
                'merchant_id' => 1,
                'name' => '经典汤羹',
                'sort' => 8
            ],
            [
                'id' => 9,
                'merchant_id' => 1,
                'name' => '经典汤羹',
                'sort' => 9
            ],
            [
                'id' => 10,
                'merchant_id' => 1,
                'name' => '海鲜',
                'sort' => 10
            ],
        ];

        foreach ($list as $item) {
            $goodsCat = new GoodsCat();
            $goodsCat->id = $item['id'];
            $goodsCat->merchant_id = $item['merchant_id'];
            $goodsCat->name = $item['name'];
            $goodsCat->sort = $item['sort'];
            $goodsCat->save();
        }
    }

}
