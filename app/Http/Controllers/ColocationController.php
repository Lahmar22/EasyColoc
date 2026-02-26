<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Membership;
use App\Models\Utilisateur;
use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    public function index()
    {
        $invitations = Invitation::where('status', 'pending')->get();
        $colocations = Colocation::where('utilisateur_id', auth()->id())->get();
        $members = Membership::join('personnes' , 'memberships.utilisateur_id' , '=', 'personnes.id')
        ->join('colocations' , 'memberships.colocation_id' , '=', 'colocations.id')
        ->select('colocations.*', 'personnes.name as user_name', 'personnes.email as user_email', 'personnes.reputation_score', 'memberships.*')
        ->where('personnes.id', auth()->id())
        ->get();

        return view('user.dashboard', compact('colocations', 'members', 'invitations'));
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
                'role' => 'admin',
                'joined_at' => now(),
                'is_active' => true,
                'utilisateur_id' => auth()->id(),
                'colocation_id' => Colocation::latest()->first()->id
            ]);

            Utilisateur::where('id', auth()->id())->update([
                'reputation_score' => 100, 'is_owner' => true
            ]);
        }

        return redirect()->route('user.dashboard');
    }
}
