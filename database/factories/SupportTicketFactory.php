<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SupportTicket;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupportTicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SupportTicket::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => $this->faker->text(5),
            'message' => $this->faker->sentence(2),
            'status' => $this->faker->word(),
            'priority' => $this->faker->text(5),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
