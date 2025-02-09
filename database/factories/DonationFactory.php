<?php

namespace Database\Factories;

use App\Models\Donation;
use App\Models\DonationItem;
use App\Models\Donor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
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
            'donor_id' => Donor::factory(),
            'date' => now(),
            'comments' => $this->faker->realText(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Donation $donation) {
            DonationItem::factory()->count(random_int(3, 6))->create([
                'donation_id' => $donation->id
            ]);
        });
    }
}
