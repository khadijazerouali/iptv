<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_number' => $this->faker->text(255),
            'amount' => $this->faker->randomNumber(1),
            'issued_at' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'status' => $this->faker->word(),
            'user_id' => \App\Models\User::factory(),
            'payment_uuid' => \App\Models\Payment::factory(),
        ];
    }
}
