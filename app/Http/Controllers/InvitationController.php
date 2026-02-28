<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\Personne;
use App\Models\Membership;

class InvitationController extends Controller
{
    public function sendEmail(request $request)
    {
        $input = $request->validate([
            'email' => 'required|email'
        ]);

        
        $status = 'pending';

        $coloc = Colocation::where('utilisateur_id', auth()->id())->first();

        $token = bin2hex(random_bytes(16));
        $link = url('/accept-invitation?token=' . $token);

        Mail::to($input['email'])->send(new TestMail($link));

        Invitation::create([
            'email' => $input['email'],
            'token' => $token,
            'colocation_id' => $coloc->id,
            'status' => $status
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Invitation envoyée avec succès !');
    }

    public function show(Request $request)
    {
        $token = $request->token;

        $invitation = Invitation::where('token', $token)->first();
       

        if (!$invitation) {
            return view('invitation.invalid');
        }

        // If user is not authenticated, store token and redirect to register/login
        if (!auth()->check()) {
            session(['invitation_token' => $token]);
            return redirect('/register');
        }

        // User is authenticated, show the action view to accept or refuse
        return view('invitation.action', compact('invitation'));
       
    }

    public function accept(Request $request)
    {
        // Require authentication
        if (!auth()->check()) {
            session(['invitation_token' => $request->token]);
            return redirect('/register');
        }

        $invitation = Invitation::where('token', $request->token)->first();

        if (!$invitation) {
            return view('invitation.invalid');
        }

        $invitation->status = 'accepted';
        $invitation->save();

        Membership::create([
            'utilisateur_id' => auth()->id(),
            'colocation_id' => $invitation->colocation_id,
            'role' => 'member',
            'joined_at' => now(),
            'is_active' => true
        ]);

        Personne::where('id', auth()->id())->update([
            'reputation_score' => 100,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Invitation acceptée avec succès !');
    }

    public function refuse(Request $request)
    {
        // Require authentication
        if (!auth()->check()) {
            session(['invitation_token' => $request->token]);
            return redirect('/register');
        }

        $invitation = Invitation::where('token', $request->token)->first();

        if (!$invitation) {
            return view('invitation.invalid');
        }

        $invitation->status = 'refused';
        $invitation->save();

        return redirect()->route('user.dashboard')->with('success', 'Invitation refusée avec succès !');
    }
}
