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
            'productCode' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'productName' => $this->faker->words(3, true),
            'productLine' => ProductLine::inRandomOrder()->first()->productLine,
            'quantityInStock' => $this->faker->numberBetween(0, 1000)
        ];
    }
}