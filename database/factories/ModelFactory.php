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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Martin\ACL\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(\Martin\Products\Meat::class, function (Faker\Generator $faker) {
    return [
        'code'  => ucwords($faker->name),
        'type'  => $faker->word,
        'variety'   => $faker->word,
        'cost_per_lb'   => $faker->numberBetween(99, 300) / 100,
    ];
});

$factory->define(\Martin\Products\Meal::class, function (Faker\Generator $faker) {
    return [
        'code'  => ucwords($faker->name),
        'label'  => $faker->word,
        'meal_value'   => $faker->numberBetween(1, 2),
    ];
});

$factory->define(\Martin\ACL\Role::class, function (Faker\Generator $faker) {
    return [
        'code'  => ucwords($faker->name),
        'label'  => $faker->word,
        'description'   => $faker->sentence(4),
    ];
});


