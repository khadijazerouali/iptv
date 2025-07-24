<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\FormRevendeur;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormRevendeurFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FormRevendeur::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => $this->faker->text(255),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'quantity' => $this->faker->randomNumber(),
            'product_uuid' => \App\Models\Product::factory(),
            'subscription_uuid' => \App\Models\Subscription::factory(),
        ];
    }
}
