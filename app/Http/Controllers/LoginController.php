<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personne;
use App\Models\Administrateur;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request){
        $input = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
        ]);

        $user = Personne::where('email', $input['email'])->first();

        if (!$user || !Hash::check($input['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $admin = Administrateur::where('personne_id', $user->id)->exists();
        $userRole = Utilisateur::where('personne_id', $user->id)->exists();

        if ($admin) {
            $role = 'admin';
        } else if ($userRole) {
            // if ($user->is_owner) {
            //     $role = 'owner';
            // } else {
            //     $role = 'member';
            // }
            $role = 'user';
        } else {
            return response()->json(['message' => 'User role not found'], 404);
        }

        Auth::login($user);

        switch ($role) {
            case 'admin': 
                return redirect()->route('administrateur.dashboard');
            case 'user':
                return redirect()->route('user.dashboard');
            
            default:
                return response()->json(['message' => 'Invalid role'], 400);
        }
    }
}
