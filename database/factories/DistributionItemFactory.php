<?php

namespace Database\Factories;

use App\Models\Distribution;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DistributionItem>
 */
class DistributionItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'distribution_id' => Distribution::factory(),
            'item_id' => Item::factory(),
            'quantity' => $this->faker->numberBetween(10, 50),
        ];
    }
}
