<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Blog;
use App\Tag;
use App\User;
use Faker\Generator as Faker;

$factory->define(Blog::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTime(),
        'location' => $faker->country,
        'duration' => $faker->randomFloat(2, 1, 24),
        'title' => $faker->sentence(3),
        'body' => $faker->paragraph,
        'goal_audience' => $faker->jobTitle,
        'user_id' => User::all()->random()->id,
        'tag_id' => rand(0,6) == 0 ? null : Tag::all()->random()->id,
    ];
});
