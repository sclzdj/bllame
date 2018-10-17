<?php

use Faker\Generator as Faker;

$factory->define(\App\Model\Admin\Admin::class, function (Faker $faker) {
    return [
        'username' => str_random(mt_rand(2,20)),
        'password' => bcrypt('admin888'), // secret
        'nickname' => str_random(mt_rand(2,20)),
        'access_type' => mt_rand(0,1),
        'status' => mt_rand(0,1),
        'remember_token' => str_random(32),
    ];
});
