<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Product;
use App\Seller;
use App\Transaction;
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '20150012', // password
        'remember_token' => Str::random(10),
        'verified'=>$verified=$faker->randomElement([User::VERIFIED_USER,User::UNVERIFIED_USER]),
        'verification_token'=>$verified == User::VERIFIED_USER ? null :User::generateVerificationCode(),
        'admin'=>$faker->randomElement([User::ADMIN_USER,User::REGULAR_USER]),
    ];
});

// category
$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
    ];
});

// product
$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity'=>$faker->numberBetween(1,10),
        'status'=>$faker->randomElement([Product::AVAILABLE_PRODUCT,Product::UNAVAILABLE_PRODUCT]),
        'image'=>$faker->randomElement(['0.jpg','1.jpg','2.jpg']),
        'seller_id'=>User::all()->random()->id,
    ];
});

// transaction
$factory->define(Transaction::class, function (Faker $faker) {
    $seller =Product::all()->random()->seller_id;
    $buyer=User::all()->except($seller)->random();
    return [
        'quantity'=>$faker->numberBetween(1,3),
        'buyer_id'=>$buyer->id,
        'product_id'=>Product::all()->random()->id,
    ];
});

