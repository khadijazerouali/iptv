<?php

namespace Database\Factories;

use App\Models\Vod;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class VodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vod::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
        ];
    }
}
