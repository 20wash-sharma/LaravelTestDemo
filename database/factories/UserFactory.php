<?php

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

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Article::class, function (Faker $faker) {
   

    return [
        
        'title' => $faker->sentence,
       
        
    ];
});


$factory->define(App\Team::class, function (Faker $faker) {
    
    return [
        'name' => $faker->name,
        'size'=>5
        
    ];
});

$factory->define(App\Post::class, function (Faker $faker) {
    
    return [
         'user_id'=>factory(App\User::class)->create()->id,
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        
    ];
});