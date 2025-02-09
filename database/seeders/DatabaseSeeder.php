<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\Entity;
use App\Models\Item;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'support@us4her.test',
        ]);


        Entity::factory(10)->create();
        Item::factory(10)->create();
        Donation::factory(10)->create();

    }
}
