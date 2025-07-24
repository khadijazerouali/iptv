<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(1),
            'slug' => $this->faker->slug(),
            'price_old' => $this->faker->randomNumber(1),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'description' => $this->faker->sentence(15),
            'view' => $this->faker->randomNumber(0),
            'category_uuid' => \App\Models\CategoryProduct::factory(),
            'type' => $this->faker->randomElement(['abonnement', 'revendeur', 'renouvellement', 'application']),
        ];
    }
}
