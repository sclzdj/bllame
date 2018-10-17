<?php

use Faker\Generator as Faker;

$factory->define(\App\Model\Admin\Role::class, function (Faker $faker) {
    return [
        'name' => str_random(mt_rand(2,20)),
        'title' => str_random(mt_rand(2,20)),
        'status' => mt_rand(0,1),
    ];
});
