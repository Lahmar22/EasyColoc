<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Membership;
use App\Models\Personne;
use App\Models\Utilisateur;
use App\Models\Invitation;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    public function index()
    {
        $invitations = Invitation::where('status', 'pending')->get();
        $colocations = Colocation::join('memberships', 'memberships.colocation_id', '=', 'colocations.id')
        ->where('memberships.utilisateur_id', auth()->id())
        ->where('memberships.is_active', true)
        ->select('colocations.*')
        ->get();
        $countColocation = $colocations->count();

        $members = Membership::join('personnes' , 'memberships.utilisateur_id' , '=', 'personnes.id')
        ->join('colocations' , 'memberships.colocation_id' , '=', 'colocations.id')
        ->select('personnes.name as user_name', 'personnes.email as user_email', 'personnes.reputation_score', 'memberships.*')
        ->where('memberships.is_active', true)
        ->get();

        $exists = Membership::where('utilisateur_id', auth()->id())->exists();
        $activeMembership = Membership::where('utilisateur_id', auth()->id())->where('is_active', true)->exists();
        $roleMembership = Membership::where('utilisateur_id', auth()->id())->where('role', 'owner')->exists();


        return view('user.dashboard', compact('colocations', 'members', 'invitations', 'exists', 'activeMembership', 'roleMembership', 'countColocation'));
    }

    public function create(Request $request){
        $input = $request->validate([
            'name' => ['required']
        ]);

        $coloc = Colocation::count();

        if($coloc < 1){
            Colocation::create([
                'name' => $input['name'],
                'status_colocation' => true,
                'token' => random_int(100000, 999999),
                'utilisateur_id' => auth()->id(),
                'created_at' => now()
            ]);
            Membership::create([
                'role' => 'owner',
                'joined_at' => now(),
                'is_active' => true,
                'utilisateur_id' => auth()->id(),
                'colocation_id' => Colocation::latest()->first()->id
            ]);

            Personne::where('id', auth()->id())->update([
                'reputation_score' => 100,
            ]);

            Utilisateur::where('personne_id', auth()->id())->update([
                'is_owner' => true,
            ]);
        }

        return redirect()->route('user.dashboard')->with('message', 'Colocation créée avec succès.');
    }

    public function join(Request $request){
        $input = $request->validate([
            'token' => ['required', 'exists:colocations,token']
        ]);

        $coloc = Colocation::where('token', $input['token'])->first();

        Membership::create([
            'role' => 'member',
            'joined_at' => now(),
            'is_active' => true,
            'utilisateur_id' => auth()->id(),
            'colocation_id' => $coloc->id
        ]);

        Personne::where('id', auth()->id())->update([
            'reputation_score' => 50,
        ]);

        return redirect()->route('user.dashboard')->with('message', 'Vous avez rejoint la colocation.');
    }

    public function quitter(Request $request){
        $membership = Membership::where('utilisateur_id', auth()->id())->first();

        if ($membership) {
            $membership->is_active = false;
            $membership->left_at = now();
            $membership->save();

            Personne::where('id', auth()->id())->decrement('reputation_score', 10);
        }

        return redirect()->route('user.dashboard')->with('message', 'Vous avez quitté la colocation.');
    }

    public function cancel(Request $request){
        $membership = Membership::where('utilisateur_id', auth()->id())->where('role', 'owner')->first();
        $payments = Payment::where('colocation_id', $membership->colocation_id)->get();
        if ($membership) {
            if ($payments->contains(function ($payment) {
                return $payment->status == false;
            })) {
                return redirect()->route('user.dashboard')->with('error', 'Impossible d\'annuler la colocation tant que des paiements sont en cours.');
            }
            Colocation::where('id', $membership->colocation_id)->delete();
            Membership::where('colocation_id', $membership->colocation_id)->delete();
            Payment::where('colocation_id', $membership->colocation_id)->delete();

            Personne::where('id', auth()->id())->decrement('reputation_score', 20);
        }

        return redirect()->route('user.dashboard')->with('message', 'Colocation annulée.');
    }

    public function destroy(Membership $membership)
    {
        if ($membership->role == 'member' && $membership->is_active) {
            $membership->is_active = false;
            $membership->left_at = now(); 
            $membership->save();

            Personne::where('id', $membership->utilisateur_id)->decrement('reputation_score', 10);

            return redirect()->route('user.dashboard')->with('message', 'Membre retiré de la colocation.');
        }


        return redirect()->route('user.dashboard')->with('error', 'Vous n\'avez pas la permission de retirer ce membre.');
    }
}
