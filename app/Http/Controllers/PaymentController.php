<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Colocation;
use App\Models\Membership;
use App\Models\Personne;

class PaymentController extends Controller
{
    public function index(){
        $membership = Membership::where('utilisateur_id', auth()->id())->first();

        if (! $membership) {
            $payments = collect();
            $due = [];
            return view('user.payments', compact('payments', 'due'));
        }

        $colocationId = $membership->colocation_id;

        $payments = Payment::join('personnes', 'payments.utilisateur_id', '=', 'personnes.id')
                            ->select('payments.*', 'personnes.name as user_name', 'personnes.id as user_id')
                            ->where('payments.colocation_id', $colocationId)
                            ->get();

        $coloc = Colocation::find($colocationId);
        $ownerName = null;
        if ($coloc && $coloc->utilisateur_id) {
            $owner = Personne::find($coloc->utilisateur_id);
            $ownerName = $owner->name ?? null;
        }

        foreach ($payments as $payment) {
            if (empty($payment->to) && $ownerName) {
                $payment->to = $ownerName;
            }
        }
 
         $due = [];
         foreach ($payments as $payment) {
             if (! $payment->status) {
                 $toName = $payment->to;
                 $due[] = [
                     'from' => $payment->user_name,
                     'to' => $toName,
                     'amount' => $payment->amount ?? $payment->montant ?? null,
                     'payment' => $payment,
                 ];
            }
        }

        return view('user.payments', compact('payments', 'due'));
    }

    public function markPaid(Request $request, Payment $payment)
    {
        $membership = Membership::where('utilisateur_id', auth()->id())->first();

        if (! $membership || $payment->colocation_id != $membership->colocation_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $payment->status = true;
        $payment->save();

        return response()->json(['success' => true]);
    }

}
