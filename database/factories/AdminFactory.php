<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(\App\Models\Admin::class, function (Faker $faker) {
    
    

    $role   = $faker->randomElement([1,2,3]);
    $gender = $faker->randomElement([1, 2]);
    

    $sex = ($gender == 1) ? 'male' : 'female' ;
    $avatar = ($sex == 'male') ? '/assets/images/avatars/male.png' : '/assets/images/avatars/female.png'; 
    return [
        'id'    => getAdminID(),
        'first_name' => $faker->firstName( $sex ),
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'gender_id' => $gender,
        'avatar' => $avatar,
        'role_id' => $role,
        'mobile' => $faker->phoneNumber,
        'password' => Hash::make('123456789'),
        'remember_token' => Str::random(10),
    ];
});
