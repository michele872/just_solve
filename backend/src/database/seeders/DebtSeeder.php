<?php

namespace Database\Seeders;

use App\Models\Debt;
use App\Models\User;
use Illuminate\Database\Seeder;

class DebtSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'agent@example.com'],
            ['name' => 'Collection Agent', 'password' => bcrypt('password')]
        );

        for ($i = 1; $i <= 5; $i++) {
            Debt::create([
                'external_id' => 'DEBT-' . $i,
                'amount' => rand(100, 1000),
                'days_overdue' => rand(5, 120),
                'status' => 'OPEN',
                'user_id' => $user->id,
            ]);
        }
    }
}
