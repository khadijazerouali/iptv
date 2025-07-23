<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\TicketReplie;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketReplieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TicketReplie::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'message' => $this->faker->sentence(2),
            'support_ticket_uuid' => \App\Models\SupportTicket::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
