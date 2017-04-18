<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       factory(App\Model\User::class, 10)->create();
       factory(App\Model\Picture::class, 100)->create();
    }
}
