<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->email,
        'role' => App\User::ROLE_USER,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
    ];
});

$factory->state(App\User::class, 'client', function () {
    return [
        'role' => App\User::ROLE_CLIENT,
    ];
});

$factory->state(App\User::class, 'user', function () {
    return [
        'role' => App\User::ROLE_USER,
    ];
});

$factory->define(App\ClientProfile::class, function (Faker\Generator $faker) {
    return [
        'user_id' => factory('App\User'),
        'name' => $faker->name,
        'surname' => $faker->name,
        'birthday' => '1996-10-21',
        'phone' => $faker->phoneNumber,
        'address' => $faker->streetAddress,
        'country' => $faker->country,
        'trading_account_number' => 0,
        'balance' => 2000,
        'open_trades' => 0,
        'close_trades' => 0,
    ];
});
