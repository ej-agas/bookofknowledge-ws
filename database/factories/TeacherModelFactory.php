<?php

/** @var Factory $factory */
use BOK\Teacher\Teacher;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Teacher::class, static function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'first_name' => $faker->firstName,
        'middle_name' => $faker->lastName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => 'secret',
        'subject' => $faker->randomElement(['ap', 'science', 'english'])
    ];
});
