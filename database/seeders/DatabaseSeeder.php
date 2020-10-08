<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.U
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CheckSeeder::class,
            CheckAttribute::class,
        ]);
    }
}
