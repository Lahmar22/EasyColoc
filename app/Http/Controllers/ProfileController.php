<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Membership;
use App\Models\Colocation;
use App\Models\Administrateur;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();


        $isAdminGlobal = Administrateur::where('personne_id', $user->id)->exists();


        $membership = Membership::where('utilisateur_id', $user->id)
                        ->where('is_active', true)
                        ->first();
        $coloc = null;
        if ($membership) {
            $coloc = Colocation::find($membership->colocation_id);
        }

        $reputation = $user->reputation_score ?? 0;

        return view('user.profile', compact('user', 'isAdminGlobal', 'membership', 'coloc', 'reputation'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $input = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:personnes,email,'.$user->id],
        ]);

        $user->name = $input['first_name'];
        $user->email = $input['email'];
        $user->save();

        return redirect()->route('user.profile')->with('success', 'Informations mises à jour.');
    }

    
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $input = $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'confirmed', 'min:8'],
        ]);

        if (!\Hash::check($input['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect']);
        }

        $user->password = \Hash::make($input['new_password']);
        $user->save();

        return redirect()->route('user.profile')->with('success', 'Mot de passe mis à jour.');
    }
}
