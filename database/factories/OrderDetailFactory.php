<?php

namespace Database\Factories;

use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
{
    protected $model = OrderDetail::class;

    public function definition()
    {
        return [
            'orderNumber' => Order::inRandomOrder()->first()->id,
            'productCode' => Product::inRandomOrder()->first()->id,
            'quantityOrdered' => $this->faker->numberBetween(1, 100),
            'priceEach' => $this->faker->randomFloat(2, 10, 1000)
        ];
    }
}
