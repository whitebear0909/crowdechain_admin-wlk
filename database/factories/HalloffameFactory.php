<?php

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

$factory->define(App\Models\Halloffame::class, function (Faker $faker) {
    return [
        'title' => $faker->catchPhrase,
        'author' => $faker->name,
        'property_alt' => $faker->text,
        'instagram_url' => $faker->url,
        'img' => $faker->imageUrl()
    ];
});
