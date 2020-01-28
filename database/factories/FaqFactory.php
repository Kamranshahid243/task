<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Faq::class, function (Faker $faker) {
    return [
        'question' => $faker->sentence(10, true),
        'answer' => $faker->sentence( 40,true),
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ];
});
