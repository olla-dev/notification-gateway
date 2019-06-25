<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Notification;
use Faker\Generator as Faker;

$factory->define(Notification::class, function (Faker $faker) {
    return [
        'msgId' => $faker->uuid,
        'msgContent' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'phone_number' => $faker->e164PhoneNumber, 
        'email' => $faker->email, 
        'category' => $faker->word, 
        'subject' => $faker->word, 
        'status' => $faker->randomElement($array = array ('SENT', 'PENDING', 'FAILED')),
        'channel' => $faker->randomElement($array = array ('SMS', 'EMAIL', 'VOICE')),
        'customer_id' => App\Customer::all()->random()->id
    ];
});