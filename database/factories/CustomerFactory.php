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
            'customerName' => $this->faker->company,
            'phone' => $this->faker->phoneNumber,
            'salesRepEmployeeNumber' => Employee::inRandomOrder()->first()->id
        ];
    }
}
