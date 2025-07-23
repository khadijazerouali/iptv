<?php

namespace Database\Factories;

use App\Models\Formiptv;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormiptvFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Formiptv::class;

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
            'device' => $this->faker->text(255),
            'application' => $this->faker->text(255),
            'channels' => $this->faker->text(255),
            'vods' => $this->faker->text(255),
            'adulte' => $this->faker->text(255),
            'mac_address' => $this->faker->text(255),
            'device_id' => $this->faker->text(255),
            'device_key' => $this->faker->text(255),
            'otp_code' => $this->faker->text(255),
            'formuler_mac' => $this->faker->text(255),
            'mag_adresse' => $this->faker->text(255),
            'note' => $this->faker->text(255),
            'product_uuid' => \App\Models\Product::factory(),
            'subscription_uuid' => \App\Models\Subscription::factory(),
        ];
    }
}
