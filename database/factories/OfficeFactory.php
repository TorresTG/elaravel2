<?php

namespace Database\Factories;

use App\Models\Office;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfficeFactory extends Factory
{
    protected $model = Office::class;

    public function definition()
    {
        return [
            'city' => $this->faker->city,
            'phone' => $this->faker->phoneNumber,
            'country' => $this->faker->country
        ];
    }
}

