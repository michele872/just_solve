<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\DebtAction;
use App\Services\DebtService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DebtController extends Controller
{

    private DebtService $debtService;

    public function __construct(DebtService $debtService)
    {
        $this->debtService = $debtService;
    }

    public function index()
    {
        return response()->json(
            Debt::where('status', 'OPEN')
                ->with('user')
                ->with('actions')
                ->orderBy('days_overdue', 'desc')
                ->get()
        );
    }

    public function suggestAction($id)
    {
        $debt = Debt::findOrFail($id);
        $suggestion = $this->debtService->getSuggestedAction($debt);

        return response()->json($suggestion);
    }

    /**
     * Applica un’azione a un debito.
     */
    public function applyAction(Request $request, $id)
    {
        $debt = Debt::findOrFail($id);

        if ($debt->status === 'RESOLVED') {
            return response()->json(['error' => 'Debt already resolved'], 400);
        }

        $validated = $request->validate([
            'action' => 'required|string|in:SEND_REMINDER,OFFER_PAYMENT_PLAN,ESCALATE_LEGAL',
        ]);

        // Calcola la reason in base alla logica business
        $reason = $this->debtService->getSuggestedAction($debt)['reason'];

        // Salva l'azione
        DebtAction::create([
            'debt_id' => $debt->id,
            'action' => $validated['action'],
            'reason' => $reason,
        ]);

        // Aggiorna il debito
        $debt->update([
            'last_action' => $validated['action'],
            'last_action_at' => now(),
        ]);

        return response()->json(['message' => 'Action applied successfully']);
    }
}
