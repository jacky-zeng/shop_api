<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //新增的seed文件 需要先运行  composer dump-autoload
        //方式一：运行 php artisan db:seed --class=AreasTableSeeder 指定运行areas表的迁移
        //方式二：运行 php artisan db:seed 将运行以下所有表的迁移
        //方式三：运行 php artisan migrate:refresh --seed 将删除所有表 并运行以下所有表的迁移

        Eloquent::unguard(); // 关闭模型插入或更新操作引发的 「mass assignment」异常

        $this->call(AreasTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(GoodsCatTableSeeder::class);
        $this->call(GoodsTableSeeder::class);
        $this->call(MerchantsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        Eloquent::reguard(); // 重新开启「mass assignment」异常抛出功能
        $this->command->info('Employee table seeded!');
    }
}
