<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'     =>'admin',
            'email'    =>'1017798347@qq.com',
            'password' =>bcrypt('123456')
        ]);
    }
}
