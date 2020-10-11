<?php

namespace Database\Factories;

use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Factories\Factory;
use function Opis\Closure\serialize;

class PharmacyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pharmacy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'coordinates' => [$this->faker->latitude,  $this->faker->longitude],
            'order' => mt_rand(0, 2),
        ];
    }
}
