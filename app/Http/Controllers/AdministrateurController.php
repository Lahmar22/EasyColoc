<?php

namespace App\Http\Controllers;

use App\Models\Personne;
use App\Models\Utilisateur;
use App\Models\Colocation;
use App\Models\Administrateur;
use Illuminate\Http\Request;
use App\Models\Membership;

class AdministrateurController extends Controller
{
    
    public function dashboard(Request $request)
    {
       
        $query = Personne::query();
        
        if ($request->has('q') && $request->q) {
            $searchTerm = $request->q;
            $query->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
        }
        
        $users = $query->get()->map(function ($user) {
            
            $utilisateur = Utilisateur::where('personne_id', $user->id)->first();
            $user->is_banned = $utilisateur ? $utilisateur->is_banned : 0;
            
            
            $admin = Administrateur::where('personne_id', $user->id)->first();
            $user->admin_id = $admin ? $admin->id : null;
            return $user;
        });

        $totalUsers = Personne::count();
        $activeUsers = Utilisateur::where('is_banned', 0)->distinct('personne_id')->count();
        $bannedUsers = Utilisateur::where('is_banned', 1)->distinct('personne_id')->count();
        $activeColocs = Colocation::where('status_colocation', 1)->count();

        $colocations = Colocation::get()->map(function ($coloc) {

            $owner = Personne::find($coloc->utilisateur_id);
            $coloc->owner_name = $owner ? $owner->name : 'Unknown';

            $coloc->members_count = Membership::where('colocation_id', $coloc->id)->count();
            
            return $coloc;
        });
        
        return view('administrateur.dashboard', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'bannedUsers' => $bannedUsers,
            'activeColocs' => $activeColocs,
            'colocations' => $colocations,
        ]);
    }
    
    
    public function banUser($userId)
    {
        $utilisateur = Utilisateur::where('personne_id', $userId)->firstOrFail();
        $utilisateur->is_banned = 1;
        $utilisateur->save();
        
        $user = Personne::find($userId);
        return redirect()->route('administrateur.dashboard')
                       ->with('success', "L'utilisateur {$user->name} a été banni.");
    }
    
   
    public function unbanUser($userId)
    {
        $utilisateur = Utilisateur::where('personne_id', $userId)->firstOrFail();
        $utilisateur->is_banned = 0;
        $utilisateur->save();
        
        $user = Personne::find($userId);
        return redirect()->route('administrateur.dashboard')
                       ->with('success', "L'utilisateur {$user->name} a été débanni.");
    }
}

