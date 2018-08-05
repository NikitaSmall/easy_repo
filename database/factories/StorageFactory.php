<?php

use Faker\Generator as Faker;

$factory->define(App\Storage::class, function (Faker $faker) {
    return [
        'key' => $faker->word,
        'user_id' => $faker->randomNumber,
        'value' => $faker->text
    ];
});
