<?php

use App\ { User };
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories seeding testing
|--------------------------------------------------------------------------
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
        'password' => bcrypt('password'),
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

        'company' => $faker->company,
        'salary'   => $faker->numberBetween($min = 5000, $max = 90000),
        'title' => $faker->sentence($nbWords = 10),
        'job_description' => $faker->paragraph($nbSentences = 15),
    ];
});
