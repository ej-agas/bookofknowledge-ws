<?php

namespace Tests\DataProviders;

use Faker\Factory as Faker;

trait UserDataProvider
{
    public function userProvider(): array
    {
        $faker = Faker::create();

        return [
            [
                [
                    'first_name' => $faker->firstName,
                    'middle_name' => $faker->lastName,
                    'last_name' => $faker->lastName,
                    'email' => $faker->freeEmail,
                    'password' => 'secret',
                ]
            ]
        ];
    }
}
