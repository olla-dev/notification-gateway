<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'uuid' => $faker->uuid,
        'name' => $faker->company,
        'instanceURL' => $faker->url,
        'contactPhone' => $faker->e164PhoneNumber, 
        'contactEmail' => $faker->email, 
        'hasSMS' => $faker->boolean,
        'hasEmail' => $faker->boolean,
        'activated' => $faker->boolean,
        'limit' => 1000,
        'credit' => $faker->numberBetween(0, 1000)
    ];
});