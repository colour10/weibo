<?php

use App\Models\Microblog;
use Illuminate\Database\Seeder;

class MicroblogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 建立 1000 条微博
        factory(Microblog::class)->times(2000)->create();
    }
}
