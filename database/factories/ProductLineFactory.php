<?php

namespace Database\Factories;

use App\Models\ProductLine;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductLineFactory extends Factory
{
    protected $model = ProductLine::class;

    public function definition()
    {
        return [
            'productLine' => $this->faker->unique()->word,
            'textDescription' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(640, 480)
        ];
    }
}
