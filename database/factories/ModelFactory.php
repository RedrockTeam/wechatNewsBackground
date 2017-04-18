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
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Model\User::class, function(Faker\Generator $faker){
    static $password;
    return [
        'username' => $faker->unique()->userName,
        'nickname' => $faker->name,
        'password' => $password ?: $password = password_hash('test',PASSWORD_BCRYPT),
    ];
});
$factory->define(App\Model\Picture::class, function(Faker\Generator $faker){

    return [
        'photo_src' => 'http://www.test/photo/'.str_random(5).'.jpg',
        'thumbnail_src' => 'http://www.test/photo/thumbnail/'.str_random(5).'.jpg',
        'article_id' => function () {
            return factory(App\Model\Article::class)->create()->id;
        },
        'user_id' => rand(1,10),
    ];
});
$factory->define(App\Model\Article::class, function(Faker\Generator $faker){
    return [
        'title' => $faker->title,
        'content' => $faker->title,
        'type_id' => rand(1,3),
        'target_url' => 'http://www.'.str_random().'.com',
        'user_id' => rand(1,10),
    ];
});
