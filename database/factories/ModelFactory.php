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
use Carbon\Carbon;

$factory->define(Martin\ACL\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => ucfirst($faker->word),
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
        'owner_id'   => factory(\Martin\ACL\User::class)->create()->id,
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

$factory->define(\Martin\Subscriptions\Plan::class, function (Faker\Generator $faker) {
    return [
        'customer_id' => factory(\Martin\ACL\User::class)->create()->id,
        'delivery_address_id' => factory(\Martin\Core\Address::class)->create()->id,
        'shipping_cost' => $faker->numberBetween(6,15),
        'pet_id' => factory(\Martin\Customers\Pet::class)->create()->id,
        'pet_weight' => $faker->numberBetween(10,90),
        'pet_activity_level' => $faker->randomElement([2, 2.5, 3]),
        'package_id' => factory(\Martin\Subscriptions\Package::class)->create()->id,
        'package_stripe_code' => $faker->word,
        'package_base' => $faker->numberBetween(100,300),
        'weeks_at_a_time' => $faker->numberBetween(1,4),
        'active' => 1,
    ];
});

$factory->define(\Martin\Core\Address::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->word,
        'company' => $faker->word,

        'street_1' => $faker->streetAddress,
        'street_2' => '',
        'city' => $faker->city,
        'province' => $faker->word,
        'postal_code' => $faker->postcode,
        'country' => $faker->country,

        'phone' => $faker->phoneNumber,
        'buzzer' => $faker->numberBetween(1000,5000),
    ];
});

$factory->define(\Martin\Core\Faq::class, function(Faker\Generator $faker) {
    return [
        'faq_category_id'  => factory(\Martin\Core\FaqCategory::class)->create()->id,
        'code'  => $faker->word,
        'question'  => $faker->sentence . '?',
        'answer' => $faker->sentence(25),
    ];
});

$factory->define(\Martin\Core\FaqCategory::class, function(Faker\Generator $faker) {
    return [
        'code'  => $faker->word,
        'label' => ucfirst($faker->word),
    ];
});

$factory->define(\Martin\Transactions\Payment::class, function(Faker\Generator $faker) {
    return [
        'customer_id'  => factory(\Martin\ACL\User::class)->create()->id,
        'collector_id' => factory(\Martin\ACL\User::class)->create()->id,
        'received_at' => $faker->dateTime,
        'format'  => $faker->randomElement([
            'stripe',
            'cash',
            'paypal',
            'other'
        ]),
        'amount_paid' => $faker->numberBetween(1000,5000),
    ];
});

$factory->define(\Martin\Delivery\Delivery::class, function(Faker\Generator $faker) {
    $user = factory(\Martin\ACL\User::class)->create();
    $order = factory(\Martin\Transactions\Order::class)->create(['customer_id' => $user->id]);
    return [
        'recipient_id' => $user->id,
        'shipped_at' => $faker->dateTime,
        'delivered_at' => $faker->dateTime,
        'courier_id'    => factory(\Martin\Delivery\Courier::class)->create()->id,
        'tracking_number' => "".$faker->numberBetween(1000,5000),
        'instructions' => $faker->sentence,
        'order_id' => $order->id,
    ];
});

$factory->define(\Martin\Transactions\Order::class, function(Faker\Generator $faker) {
    return [
        'plan_id'  => factory(\Martin\Subscriptions\Plan::class)->create()->id,
        'customer_id'  => factory(\Martin\ACL\User::class)->create()->id,
        'delivery_address_id' => factory(\Martin\Core\Address::class)->create()->id,
        'subtotal' => $faker->numberBetween(1000,5000),
        'tax' => $faker->numberBetween(1000,5000),
        'total_cost' => $faker->numberBetween(1000,5000),
        'deliver_by' => Carbon::now()->addDays(3),
    ];
});

$factory->define(\Martin\Delivery\Courier::class, function(Faker\Generator $faker) {
    return [
        'code'  => $faker->word,
        'label' => ucfirst($faker->word),
    ];
});




