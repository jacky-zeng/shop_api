<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
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
                'name' => '美食',
                'image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/10/near1.png',
                'sort' => 1
            ],
            [
                'id' => 2,
                'name' => '新店特惠',
                'image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/10/near2.png',
                'sort' => 2
            ],
            [
                'id' => 3,
                'name' => '浪漫鲜花',
                'image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/10/near3.png',
                'sort' => 3
            ],
            [
                'id' => 4,
                'name' => '果蔬生鲜',
                'image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/10/near4.png',
                'sort' => 4
            ],
            [
                'id' => 5,
                'name' => '煲仔烧腊',
                'image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/10/near5.png',
                'sort' => 5
            ],
            [
                'id' => 6,
                'name' => '晚餐',
                'image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/10/near6.png',
                'sort' => 6
            ],
            [
                'id' => 7,
                'name' => '快餐便当',
                'image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/10/near7.png',
                'sort' => 7
            ],
            [
                'id' => 8,
                'name' => '甜品饮品',
                'image' => 'https://www.zengyanqi.com/wp-content/uploads/2017/10/near8.png',
                'sort' => 8
            ],
        ];

        foreach ($list as $item) {
            $category = new Category();
            $category->id = $item['id'];
            $category->name = $item['name'];
            $category->image = $item['image'];
            $category->sort = $item['sort'];
            $category->save();
        }
    }

}
