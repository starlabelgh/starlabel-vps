<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enums\UserRole;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    $roleArray = [UserRole::ADMIN, UserRole::CUSTOMER, UserRole::SHOPOWNER, UserRole::DELIVERYBOY];

    static $password;
    return [
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'username'       => $faker->userName,
        'email'          => $faker->unique()->safeEmail,
        'phone'          => $faker->phoneNumber,
        'address'        => $faker->address,
        'roles'          => $roleArray[array_rand($roleArray, 1)],
        'password'       => $password ?: $password = bcrypt('123456'),
        'remember_token' => Str::random(10),
    ];
});
