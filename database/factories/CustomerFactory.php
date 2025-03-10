<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'customerNumber' => $this->faker->unique()->numberBetween(10000, 99999),
            'customerName' => $this->faker->company,
            'phone' => $this->faker->phoneNumber,
            'salesRepEmployeeNumber' => Employee::inRandomOrder()->first()->employeeNumber
        ];
    }
}
