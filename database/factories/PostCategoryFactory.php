<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PostCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(5),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(5),
            'keywords' => $this->faker->text(5),
            'content' => $this->faker->text(),
        ];
    }
}
