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
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/**
 * Product
 */
$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'price' => $faker->randomFloat(2, 0, 99),
        'description' => $faker->paragraph(8)
    ];
});

/**
 * Address
 */
$factory->define(App\Address::class, function (Faker\Generator $faker) {
    return [
        'customer_id' =>  function () {
            return factory(\App\Customer::class)->create()->id;
        },
        'address_1' => $faker->streetAddress,
        'town' => $faker->city,
        'county' => $faker->country,
        'postcode' => $faker->postcode,
        'primary' => 1
    ];
});

/**
 * Order
 */
$factory->define(App\Order::class, function (Faker\Generator $faker) {
    return [
        'customer_id' => function() {
            return factory(\App\Customer::class)->create()->id;
        },
        'address_id' => function(array $order) {
            return factory(\App\Address::class)->create()->id;
        },
        'processed' => 0,
        'delivered' => 0
    ];
});

/**
 * Customer
 */
$factory->define(App\Customer::class, function (Faker\Generator $faker) {
    return [
        'firstname' => $faker->firstName,
        'surname' => $faker->lastName,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'password' => bcrypt($faker->password)
    ];
});