<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'api_token' => str_random(60)
    ];
});

$factory->define(App\Weight::class, function (Faker\Generator $faker) {
    return [
        'weight' => $faker->numberBetween(160, 180)
    ];
});
