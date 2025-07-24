<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\CategoryProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(15),
            'icon_url' => $this->faker->text(5),
        ];
    }
}
