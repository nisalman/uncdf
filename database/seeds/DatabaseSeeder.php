<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Mm_profile;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $mm_profile=factory(\App\Mm_profile::class,500)->create();
        //$users = factory(App\User::class, 10)->create();

    }
}
