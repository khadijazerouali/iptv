<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'payment_method' => $this->faker->text(255),
            'amount' => $this->faker->randomNumber(1),
            'transaction_id' => $this->faker->text(255),
            'status' => $this->faker->word(),
            'subscription_uuid' => \App\Models\Subscription::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
