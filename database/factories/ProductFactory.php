<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductLine;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'productName' => $this->faker->word(),
            'productLine' => ProductLine::inRandomOrder()->first()->id,
            'quantityInStock' => $this->faker->numberBetween(0, 1000)
        ];
    }
}