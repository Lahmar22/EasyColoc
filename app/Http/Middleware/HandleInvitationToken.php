<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleInvitationToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // If user is authenticated and there's an invitation token in session,
        // redirect to the invitation action page
        if (auth()->check() && session('invitation_token')) {
            $token = session('invitation_token');
            session()->forget('invitation_token');
            return redirect('/accept-invitation?token=' . $token);
        }

        return $next($request);
    }
}
