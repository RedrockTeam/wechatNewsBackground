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
        'photo_src' => "http://www.pumbf.me/emergencytask/public/index.php/api/Photo/1492871830-RAgKwVPp.jpeg",
        'thumbnail_src' => 'http://www.pumbf.me/emergencytask/public/index.php/api/Photo/1492871830-BACxSAmH.jpeg',
        'article_id' => function () {
            return factory(App\Model\Article::class)->create()->id;
        },
        'user_id' => rand(1,10),
    ];
});
$factory->define(App\Model\Article::class, function(Faker\Generator $faker){
    return [
        'title' => '人生难得一知己（看完泪流)',
        'content' => '在我们的匆匆人生中总会遇见这样那样的人他们在我们的生命中停留说过一些话做过一些事给过一些温暖也带来一些伤害但',
        'type_id' => rand(1,3),
        'target_url' => 'http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl=http://mmbiz.qpic.cn/mmbiz/CoJreiaicGKekJ76CHbbBq9sC24n6Mv36ema5UHuMWNvv2W22SKIGRdlzxHuBteVsqLOc7YlxOFDWq423gdpMYmQ/640',
        'user_id' => rand(1,10),
    ];
});
