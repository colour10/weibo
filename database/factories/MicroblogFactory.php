<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Microblog;
use Faker\Generator as Faker;

$factory->define(Microblog::class, function (Faker $faker) {
    $dateTime = $faker->date() . ' ' . $faker->time();
    return [
        'user_id'    => $faker->randomElement([1, 2, 3]),
        'content'    => $faker->text(),
        'created_at' => $dateTime,
        'updated_at' => $dateTime,
    ];
});
