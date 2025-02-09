<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sanitary_items = [
            "Sanitary Pads",
            "Tampons",
            "Menstrual Cups",
            "Panty Liners",
            "Period Underwear",
            "Disposable Wipes",
            "Hot Water Bottle",
            "Feminine Wash",
            "Disposable Gloves",
            "Hand Sanitizer"
        ];

        $randomItem = $this->faker->randomElement($sanitary_items);

        if (\App\Models\Item::where('name', $randomItem)->exists()) {
            $randomItem = $this->faker->unique()->word;
        }

        return [
            'user_id' => User::factory(),
            'name' => $randomItem,
        ];

    }
}
