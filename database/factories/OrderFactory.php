<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'orderDate' => $this->faker->dateTimeThisYear(),
            'status' => $this->faker->randomElement(['Pending', 'Processing', 'Shipped', 'Delivered']),
            'customerNumber' => Customer::inRandomOrder()->first()->id
        ];
    }
}
