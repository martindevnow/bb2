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

$factory->define(\Martin\Customers\Pet::class, function (Faker\Generator $faker) {
    return [
        'name'  => ucwords($faker->word),
        'species'  => ucwords($faker->word),
        'breed'   => $faker->word,
        'weight'   => $faker->numberBetween(35, 120),
        'activity_level'   => $faker->randomElement([2.0, 2.5, 3.0]),
        'birthday'   => $faker->dateTime,
        'user_id'   => factory(\Martin\ACL\User::class)->create()->id,
    ];
});

$factory->define(\Martin\Products\Meat::class, function (Faker\Generator $faker) {
    return [
        'code'  => ucwords($faker->word),
        'type'  => $faker->word,
        'variety'   => $faker->word,
        'cost_per_lb'   => $faker->numberBetween(99, 300) / 100,
    ];
});

$factory->define(\Martin\Products\Topping::class, function (Faker\Generator $faker) {
    return [
        'code'  => ucwords($faker->word),
        'label'  => $faker->word,
        'cost_per_kg'   => $faker->numberBetween(99, 300) / 100,
    ];
});

$factory->define(\Martin\Products\Meal::class, function (Faker\Generator $faker) {
    return [
        'code'  => ucwords($faker->word),
        'label'  => $faker->word,
        'meal_value'   => $faker->numberBetween(1, 2),
    ];
});

$factory->define(\Martin\ACL\Role::class, function (Faker\Generator $faker) {
    return [
        'code'  => ucwords($faker->word),
        'label'  => $faker->word,
        'description'   => $faker->sentence(4),
    ];
});

$factory->define(\Martin\Subscriptions\Package::class, function (Faker\Generator $faker) {
    return [
        'code'  => ucwords($faker->word),
        'label'  => $faker->word,
    ];
});


