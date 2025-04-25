<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Salary;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve all existing users
        $users = User::all();

        // Check if there are users in the database
        if ($users->isEmpty()) {
            $this->command->info("No users found to generate salaries.");
            return;
        }

        // Generate 3 salary records per user
        $users->each(function ($user) {
            // Creating salary records for the user
            Salary::factory(30)->create([
                'user_id' => $user->id,  // Assign the existing user ID
            ]);
        });

        $this->command->info("Salaries generated for all users.");
    }
}
