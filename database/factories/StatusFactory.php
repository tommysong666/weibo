<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Status;
use Faker\Generator as Faker;

$factory->define(Status::class, function (Faker $faker) {
    $datetime=$faker->date.' '.$faker->time;
    return [
        'user_id'=>$faker->randomElement([1,2,3,4,5]),
        'content'=>$faker->text(),
        'created_at'=>$datetime,
        'updated_at'=>$datetime
    ];
});
