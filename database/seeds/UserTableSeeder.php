<?php

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * 用户填充
 *
 * Class UserTableSeeder
 */
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 逻辑
        factory(User::class)->times(100)->create();

        $user = User::find(1);
        $user->name = 'colour10';
        $user->email = 'admin@liuzongyang.com';
        $user->save();
    }
}
