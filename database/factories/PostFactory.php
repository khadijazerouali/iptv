<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

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
            'description' => $this->faker->sentence(15),
            'keywords' => $this->faker->text(255),
            'content' => $this->faker->text(),
            'post_category_uuid' => \App\Models\PostCategory::factory(),
        ];
    }
}
