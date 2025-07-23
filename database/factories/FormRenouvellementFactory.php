<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\FormRenouvellement;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormRenouvellementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FormRenouvellement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'duration' => $this->faker->text(255),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'number' => $this->faker->text(255),
            'product_uuid' => \App\Models\Product::factory(),
            'subscription_uuid' => \App\Models\Subscription::factory(),
        ];
    }
}
