<?php

namespace Database\Seeders;

use App\Models\Debt;
use App\Models\DebtAction;
use Illuminate\Database\Seeder;

class DebtActionSeeder extends Seeder
{
    /**
     * Seed a plausible action history: each debt gets 0-2 of the escalation
     * steps in order, and its last_action reflects the most recent one.
     */
    public function run(): void
    {
        $steps = [
            'SEND_REMINDER' => 'Debt is overdue but within 30 days.',
            'OFFER_PAYMENT_PLAN' => 'Debt has been overdue for more than 30 days.',
        ];

        foreach (Debt::all() as $debt) {
            $applied = array_slice($steps, 0, rand(0, count($steps)), true);
            $date = now()->subDays(count($applied) * 7);

            foreach ($applied as $action => $reason) {
                DebtAction::forceCreate([
                    'debt_id' => $debt->id,
                    'action' => $action,
                    'reason' => $reason,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);

                $debt->update([
                    'last_action' => $action,
                    'last_action_at' => $date,
                ]);

                $date = $date->copy()->addDays(7);
            }
        }
    }
}
