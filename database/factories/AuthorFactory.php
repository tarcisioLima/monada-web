<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Author::class, function (Faker $faker){
    return [
        'username' => $faker->unique(),
        'bio' => $faker->text(),
        'actived' => true,
        'facebook'  => true,
        'twitter'  => true,
        'youtube'  => true,
        'instagram'  => true,
        'site'  => true,
        'image'  => true,
        'userId' => $factory->create(App\Models\User::class)->id
    ];
});