<?php

namespace Database\Factories;

use App\Models\Donation;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DonationItem>
 */
class DonationItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'donation_id' => Donation::factory(),
            'item_id' => Item::factory(),
            'quantity' => $this->faker->numberBetween(1000, 5000),
        ];
    }
}
