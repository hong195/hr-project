<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CheckData;

class CheckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $checks = $this->createCheck();
        $checks->each(function($check) {
            $check->meta()->saveMany([
                new CheckData(['name' => 'sum', 'value' => 100000]),
                new CheckData(['name' => 'ethics', 'value' => 1]),
                new CheckData(['name' => 'consultation', 'value' => 1]),
                new CheckData(['name' => 'consultation_product', 'value' => 0]),
            ]);
        });
    }

    private function createCheck($count = 1) {
        return \App\Models\Check::factory($count)->create();
    }
}
