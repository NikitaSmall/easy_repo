<?php

use Faker\Generator as Faker;

$factory->define(App\ApiKey::class, function (Faker $faker) {
    return [
        'key' => $faker->md5,
        'user_id' => function() {
          return factory(App\User::class)->create()->id;
        }
    ];
});
