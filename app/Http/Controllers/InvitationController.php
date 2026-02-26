<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\Personne;

class InvitationController extends Controller
{
    public function sendEmail(request $request)
    {
        $input = $request->validate([
            'email' => 'required|email'
        ]);

        $user = auth()->id();
        $status = 'pending';

        $coloc = Colocation::where('utilisateur_id', $user)->first();

        $token = bin2hex(random_bytes(16));
        $link = url('/accept-invitation?token=' . $token);

        Mail::to($input['email'])->send(new TestMail($link));

        Invitation::create([
            'email' => $input['email'],
            'token' => $token,
            'colocation_id' => $coloc->id,
            'utilisateur_id' => $user,
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

        return view('invitation.success');
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

        return view('invitation.refused');
    }
}
