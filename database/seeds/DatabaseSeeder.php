<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * 数据填充器
 *
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 暂时关闭批量赋值
        Model::unguard();
        $this->call(UserTableSeeder::class);
        $this->call(MicroblogTableSeeder::class);
        $this->call(FollowerTableSeeder::class);
        Model::reguard();
    }
}
