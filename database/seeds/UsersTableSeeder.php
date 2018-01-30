<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
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
                'name' => 'user001',
                'email' => '001@qq.com',
                'password' => bcrypt('123456')
            ],
            [
                'id' => 2,
                'name' => 'user002',
                'email' => '002@qq.com',
                'password' => bcrypt('123456')
            ],
            [
                'id' => 3,
                'name' => 'user003',
                'email' => '003@qq.com',
                'password' => bcrypt('123456')
            ],
            [
                'id' => 4,
                'name' => 'user004',
                'email' => '004@qq.com',
                'password' => bcrypt('123456')
            ],
            [
                'id' => 5,
                'name' => 'user005',
                'email' => '005@qq.com',
                'password' => bcrypt('123456')
            ],
            [
                'id' => 6,
                'name' => 'user006',
                'email' => '006@qq.com',
                'password' => bcrypt('123456')
            ],
            [
                'id' => 7,
                'name' => 'user007',
                'email' => '007@qq.com',
                'password' => bcrypt('123456')
            ],
            [
                'id' => 8,
                'name' => 'user008',
                'email' => '008@qq.com',
                'password' => bcrypt('123456')
            ],
            [
                'id' => 9,
                'name' => 'user009',
                'email' => '009@qq.com',
                'password' => bcrypt('123456')
            ],
            [
                'id' => 10,
                'name' => 'user010',
                'email' => '010@qq.com',
                'password' => bcrypt('123456')
            ],
            [
                'id' => 11,
                'name' => 'user011',
                'email' => '011@qq.com',
                'password' => bcrypt('123456')
            ],
            [
                'id' => 12,
                'name' => 'user012',
                'email' => '012@qq.com',
                'password' => bcrypt('123456')
            ],
        ];

        foreach ($list as $item) {
            $user = new User();
            $user->id = $item['id'];
            $user->name = $item['name'];
            $user->email = $item['email'];
            $user->password = $item['password'];
            $user->save();
        }
    }

}
