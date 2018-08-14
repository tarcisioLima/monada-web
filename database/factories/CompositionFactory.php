<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Composition::class, function (Faker $faker) {
    return [
        'title' => $faker->text(40),
        'body' => $faker->text(200)
    ];
});
