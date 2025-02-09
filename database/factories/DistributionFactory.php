<?php

namespace Database\Factories;

use App\Models\Distribution;
use App\Models\DistributionItem;
use App\Models\Entity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Distribution>
 */
class DistributionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'entity_id' => Entity::factory(),
            'date' => $this->faker->dateTimeBetween("-3 years"),
            'comments' => $this->faker->realText(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Distribution $distribution) {
            DistributionItem::factory()->count(random_int(3, 6))->create([
                'distribution_id' => $distribution->id
            ]);
        });
    }
}
