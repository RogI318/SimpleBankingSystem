<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Account;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Account::create([
            'user_id' => $user->id,
            'account_number' => 'ACC-1001',
            'balance' => 1000.00,
        ]);

        Account::create([
            'user_id' => $user->id,
            'account_number' => 'ACC-1002',
            'balance' => 500.00,
        ]);

    }
}
