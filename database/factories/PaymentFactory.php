<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'customerNumber' => Customer::inRandomOrder()->first()->customerNumber,
            'checkNumber' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{6}'),
            'paymentDate' => $this->faker->dateTimeThisYear(),
            'amount' => $this->faker->randomFloat(2, 100, 10000)
        ];
    }
}