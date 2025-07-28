<?php

namespace Database\Factories;

use App\Models\PromoCode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PromoCode>
 */
class PromoCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $discountType = $this->faker->randomElement(['percentage', 'fixed']);
        $discountValue = $discountType === 'percentage' 
            ? $this->faker->numberBetween(5, 50) 
            : $this->faker->numberBetween(5, 100);

        return [
            'code' => strtoupper($this->faker->bothify('PROMO####')),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'discount_type' => $discountType,
            'discount_value' => $discountValue,
            'min_amount' => $this->faker->optional(0.3)->numberBetween(10, 200),
            'max_discount' => $discountType === 'percentage' 
                ? $this->faker->optional(0.5)->numberBetween(10, 50) 
                : null,
            'usage_limit' => $this->faker->numberBetween(1, 100),
            'used_count' => $this->faker->numberBetween(0, 50),
            'valid_from' => $this->faker->optional(0.2)->dateTimeBetween('-1 month', '+1 month'),
            'valid_until' => $this->faker->optional(0.8)->dateTimeBetween('+1 day', '+6 months'),
            'is_active' => $this->faker->boolean(80), // 80% de chance d'être actif
            'applies_to' => $this->faker->randomElement(['all', 'specific_products', 'specific_categories']),
            'applies_to_ids' => $this->faker->optional()->randomElements(range(1, 10), $this->faker->numberBetween(1, 5)),
            'email_sent_count' => $this->faker->numberBetween(0, 100),
            'last_sent_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Indicate that the promo code is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'valid_from' => Carbon::now()->subDay(),
            'valid_until' => Carbon::now()->addMonth(),
        ]);
    }

    /**
     * Indicate that the promo code is expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'valid_until' => Carbon::now()->subDay(),
        ]);
    }

    /**
     * Indicate that the promo code is not yet valid.
     */
    public function future(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'valid_from' => Carbon::now()->addDay(),
        ]);
    }

    /**
     * Indicate that the promo code is exhausted (reached usage limit).
     */
    public function exhausted(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'usage_limit' => 10,
            'used_count' => 10,
        ]);
    }

    /**
     * Indicate that the promo code is a percentage discount.
     */
    public function percentage(): static
    {
        return $this->state(fn (array $attributes) => [
            'discount_type' => 'percentage',
            'discount_value' => $this->faker->numberBetween(5, 50),
        ]);
    }

    /**
     * Indicate that the promo code is a fixed amount discount.
     */
    public function fixed(): static
    {
        return $this->state(fn (array $attributes) => [
            'discount_type' => 'fixed',
            'discount_value' => $this->faker->numberBetween(5, 100),
        ]);
    }

    /**
     * Indicate that the promo code applies to all products.
     */
    public function appliesToAll(): static
    {
        return $this->state(fn (array $attributes) => [
            'applies_to' => 'all',
            'applies_to_ids' => null,
        ]);
    }

    /**
     * Indicate that the promo code applies to specific products.
     */
    public function appliesToProducts(array $productIds): static
    {
        return $this->state(fn (array $attributes) => [
            'applies_to' => 'specific_products',
            'applies_to_ids' => $productIds,
        ]);
    }

    /**
     * Indicate that the promo code applies to specific categories.
     */
    public function appliesToCategories(array $categoryIds): static
    {
        return $this->state(fn (array $attributes) => [
            'applies_to' => 'specific_categories',
            'applies_to_ids' => $categoryIds,
        ]);
    }
} 