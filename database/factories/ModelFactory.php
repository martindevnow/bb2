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
use Martin\ACL\User;
use Martin\Customers\Pet;
use Martin\Products\Meat;
use Martin\Products\Product;
use Martin\Subscriptions\Plan;
use Martin\Transactions\Order;

/**
 * Address
 */
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

/**
 * Attachment
 */
$factory->define(\Martin\Core\Attachment::class, function (Faker\Generator $faker) {
    $attachmentable = $faker->randomElement([
        factory(Pet::class)->create(),
        factory(Order::class)->create(),
        factory(User::class)->create(),
    ]);

    return [
        'uploader_id'  => factory(User::class)->create()->id,
        'original_filename'  => $faker->word,
        'filename'  => $faker->word,
        'extension'  => $faker->word,
        'attachmentable_id'   => $attachmentable->id,
        'attachmentable_type'   => get_class($attachmentable),
    ];
});

/**
 * Courier
 */
$factory->define(\Martin\Delivery\Courier::class, function(Faker\Generator $faker) {
    return [
        'code'  => $faker->word,
        'label' => ucfirst($faker->word),
    ];
});

/**
 * Delivery
 */
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

/**
 * FAQ
 */
$factory->define(\Martin\Core\Faq::class, function(Faker\Generator $faker) {
    return [
        'faq_category_id'  => factory(\Martin\Core\FaqCategory::class)->create()->id,
        'code'  => $faker->word,
        'question'  => $faker->sentence . '?',
        'answer' => $faker->sentence(25),
    ];
});

/**
 * FAQ Category
 */
$factory->define(\Martin\Core\FaqCategory::class, function(Faker\Generator $faker) {
    return [
        'code'  => $faker->word,
        'label' => ucfirst($faker->word),
    ];
});

/**
 * Image
 */
$factory->define(\Martin\Core\Image::class, function (Faker\Generator $faker) {
    $imageable = $faker->randomElement([
        factory(Product::class)->create(),
        factory(Pet::class)->create(),
        factory(User::class)->create(),
    ]);

    return [
        'uploader_id'  => factory(User::class)->create()->id,
        'content'  => $faker->sentence(15),
        'height'  => $faker->numberBetween(150,500),
        'width'  => $faker->numberBetween(150,500),
        'extension'  => $faker->word,
        'name'  => $faker->word,
        'imageable_id'   => $imageable->id,
        'imageable_type'   => get_class($imageable),
    ];
});

/**
 * Inventory
 */
$factory->define(\Martin\Products\Inventory::class, function(Faker\Generator $faker) {
    $changeable = rand(0,1) >= 0 ? factory(Order::class)->create(): null;
    $inventoryable = rand(0,1) >= 0.5
        ? factory(\Martin\Products\Meat::class)->create()
        : factory(\Martin\Products\Product::class)->create();
    return [
        'changeable_id'  => $changeable->id,
        'changeable_type'  => get_class($changeable),
        'size'  => $inventoryable instanceof \Martin\Products\Meat
            ? null
            : $inventoryable instanceof \Martin\Products\Product
                ? $inventoryable->size
                : $faker->numberBetween(150, 400),
        'inventoryable_id'  => $inventoryable->id,
        'inventoryable_type'  => get_class($inventoryable),
        'change' => $faker->numberBetween(1,500) * -1,
        'current'   => $faker->numberBetween(200,500),
    ];
});

/**
 * Meal
 */
$factory->define(\Martin\Products\Meal::class, function (Faker\Generator $faker) {
    return [
        'code'  => ucwords($faker->word),
        'label'  => $faker->word,
        'meal_value'   => $faker->numberBetween(1, 2),
    ];
});

/**
 * Meat
 */
$factory->define(\Martin\Products\Meat::class, function (Faker\Generator $faker) {
    return [
        'code'  => ucwords($faker->word),
        'type'  => $faker->word,
        'variety'   => $faker->word,
        'cost_per_lb'   => $faker->numberBetween(99, 300) / 100,
    ];
});

/**
 * Note
 */
$factory->define(\Martin\Core\Note::class, function (Faker\Generator $faker) {
    $noteable = $faker->randomElement([
        factory(Plan::class)->create(),
        factory(Pet::class)->create(),
        factory(User::class)->create(),
    ]);

    return [
        'author_id'  => factory(User::class)->create()->id,
        'content'  => $faker->sentence(15),
        'noteable_id'   => $noteable->id,
        'noteable_type'   => get_class($noteable),
    ];
});

/**
 * Order
 */
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

/**
 * Package
 */
$factory->define(\Martin\Subscriptions\Package::class, function (Faker\Generator $faker) {
    return [
        'code'  => ucwords($faker->word),
        'label'  => $faker->word,
        'customization' => $faker->randomElement([0,1]),
        'level' => $faker->randomElement([0,1,2]),
    ];
});

/**
 * Payment
 */
$factory->define(\Martin\Transactions\Payment::class, function(Faker\Generator $faker) {
    $types = [
        'cash',
        'interac',
        'e-transfer',
        'stripe',
        'paypal',
    ];

    return [
        'customer_id'  => factory(\Martin\ACL\User::class)->create()->id,
        'collector_id' => factory(\Martin\ACL\User::class)->create()->id,
        'received_at' => $faker->dateTime,
        'format'  => $faker->randomElement($types),
        'amount_paid' => $faker->numberBetween(1000,5000),
    ];
});

/**
 * Permissions
 */
$factory->define(\Martin\ACL\Permission::class, function (Faker\Generator $faker) {
    return [
        'label'  => ucwords($faker->word),
        'code'  => ucwords($faker->word),
        'description'  => ucwords($faker->word),
    ];
});

/**
 * Pet
 */
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

/**
 * Plan
 */
$factory->define(\Martin\Subscriptions\Plan::class, function (Faker\Generator $faker) {
    $types = [
        'cash',
        'interac',
        'e-transfer',
        'stripe',
        'paypal',
    ];

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
        'weekly_cost' => $faker->numberBetween(2000,4000),
        'weeks_at_a_time' => $faker->numberBetween(1,4),
        'active' => 1,
        'payment_method'    => $faker->randomElement($types),
    ];
});

/**
 * Products
 */
$factory->define(\Martin\Products\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->word,
        'description_long'=> $faker->word,
        'size'  => $faker->randomElement(['small', '50g', '10pieces', '100ml']),
        'sku'   => $faker->word,
        'ingredients' => $faker->words(5, true),
        'price' => $faker->numberBetween(300, 600),
    ];
});

/**
 * PurchaseOrder
 */
$factory->define(\Martin\Vendors\PurchaseOrder::class, function (Faker\Generator $faker) {
    return [
        'vendor_id' => factory(Martin\Vendors\Vendor::class)->create()->id,
        'received' => false,
        'received_at'=> null,
        'ordered'  => true,
        'ordered_at'   => Carbon::now()->subDays(4),
        'total' => $faker->numberBetween(150,300),
    ];
});

/**
 * PurchaseOrderDetail
 */
$factory->define(\Martin\Vendors\PurchaseOrderDetail::class, function (Faker\Generator $faker) {
    $purchasable = $faker->randomElement([
        factory(Meat::class)->create(),
    ]);

    return [
        'purchase_order_id' => factory(Martin\Vendors\PurchaseOrder::class)->create()->id,
        'purchasable_type' => get_class($purchasable),
        'purchasable_id' => $purchasable->id,
        'quantity' => $faker->numberBetween(15,50),
    ];
});

/**
 * Role
 */
$factory->define(\Martin\ACL\Role::class, function (Faker\Generator $faker) {
    return [
        'code'  => ucwords($faker->word),
        'label'  => $faker->word,
        'description'   => $faker->sentence(4),
    ];
});

/**
 * Topping
 */
$factory->define(\Martin\Products\Topping::class, function (Faker\Generator $faker) {
    return [
        'code'  => ucwords($faker->word),
        'label'  => $faker->word,
        'cost_per_kg'   => $faker->numberBetween(99, 300) / 100,
    ];
});

/**
 * Users
 */
$factory->define(Martin\ACL\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => ucfirst($faker->word),
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/**
 * Vendor
 */
$factory->define(Martin\Vendors\Vendor::class, function (Faker\Generator $faker) {
    return [
        'label' => ucfirst($faker->word),
        'code' => ($faker->word),
    ];
});



