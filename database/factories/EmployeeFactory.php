<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Office;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'lastName' => $this->faker->lastName,
            'firstName' => $this->faker->firstName,
            'officeCode' => Office::inRandomOrder()->first()->id
        ];
    }
}
