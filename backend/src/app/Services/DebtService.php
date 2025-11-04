<?php
namespace App\Services;

use App\Models\Debt;

class DebtService
{
    /**
     * Determina l'azione suggerita e la motivazione.
     */
    public function getSuggestedAction(Debt $debt): array
    {
        if ($debt->days_overdue >= 60 && $debt->amount >= 1000) {
            return [
                'action' => 'ESCALATE_LEGAL',
                'reason' => 'Debt is overdue for more than 60 days and exceeds €1000.',
            ];
        }

        if ($debt->days_overdue >= 30) {
            return [
                'action' => 'OFFER_PAYMENT_PLAN',
                'reason' => 'Debt has been overdue for more than 30 days.',
            ];
        }

        return [
            'action' => 'SEND_REMINDER',
            'reason' => 'Debt is overdue but within 30 days.',
        ];
    }
}
