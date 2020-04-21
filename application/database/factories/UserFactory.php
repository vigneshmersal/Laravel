<?php

use App\ { User };
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories seeding testing
|--------------------------------------------------------------------------
| Call By
| factory('App\User', 2)->create();
*/

$factory->define(User::class, function (Faker $faker) {
    $name = $faker->name;
    return [
        'name' => $name,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'slug' => Str::slug($name, '_'),

        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->randomNumber(8),
        'password' => bcrypt('password'), // bcrypt(str_random(10))
        'role' => $faker->randomElement(['admin', 'doctor']),
    	'sex' => $faker->randomElement(['Male', 'Female']),
    	'dob' => "1995-03-12",
    	'blood_group' => $faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),

        'biography' => $faker->realText, // text
        'mobile_verified' => true,

        'address_line1' => $faker->address,
        'country' => $faker->country,
        'state' => $faker->state,
        'city' => $faker->city,

        "user_id" => function(){
            return \App\User::all()->random();
        },
        'user_id' => 'factory:App\User',

        'company' => $faker->company,
        "stock" => $faker->randomDigit,
        'salary'   => $faker->numberBetween(5000, 90000),
        'title' => $faker->sentence, // sentence(10)
        'description, body' => $faker->paragraph, // paragraph(30)

        'remember_token' => str_random(10),
    ];
});
