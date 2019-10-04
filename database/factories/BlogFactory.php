<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Blog;
use Faker\Generator as Faker;

$factory->define(Blog::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTime(),
        'location' => $faker->country,
        'duration' => $faker->randomFloat(2, 1, 24),
        'title' => $faker->sentence(3),
        'body' => $faker->paragraph,
        'goal_audience' => $faker->jobTitle,
        'user_id' => \App\User::first(),
    ];
});
