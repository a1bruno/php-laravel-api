<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory(2)->create([
            //'name' => 'Bruno',
            //'email' => 'brunoteste@me.com',
            'date_of_birth' => Carbon::now()->subYears(20)->format('Y-m-d')
        ]);
    }
}
