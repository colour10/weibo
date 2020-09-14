<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class FollowerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 使用第一个用户对除自己以外的用户进行关注，接着再让所有用户去关注第一个用户
        // 取出第 1 个用户
        $user = User::first();
        $user_id = $user->id;
        // 其他的用户集合
        $users = User::all()->slice(1);
        $user_ids = $users->pluck('id')->toArray();
        // 第一个用户开始关注
        $user->follow($user_ids);
        // 所有的用户开始关注第一个用户
        foreach ($users as $currentUser) {
            $currentUser->follow($user_id);
        }
    }
}
