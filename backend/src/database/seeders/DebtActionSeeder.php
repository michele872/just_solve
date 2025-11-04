<?php

namespace Database\Seeders;

use App\Models\Debt;
use App\Models\DebtAction;
use Illuminate\Database\Seeder;

class DebtActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = [
            'SEND_REMINDER',
            'CALL_DEBTOR',
            'ESCALATE_LEGAL',
            'RESOLVE_DEBT',
            'MARK_AS_IRRECOVERABLE',
        ];

        foreach (Debt::all() as $debt) {
            foreach (array_slice($actions, 0, rand(2, 4)) as $action) {
                DebtAction::create([
                    'debt_id' => $debt->id,
                    'action' => $action,
                    'reason' => fake()->optional()->sentence(),
                ]);
            }
        }
    }
}
