<?php

namespace App\Http\Middleware;
use App\Models\Team;
use Auth;
use Closure;
use App\Models\TeamInvitation;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Illuminate\Http\Request;


class HasTeam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::user()->currentTeam->count() === 0) {
            //check to see if there is a pending invite.

            $invitation = TeamInvitation::where('email', '=', Auth::user()->email)->first();
            if ($invitation) {
                app(AddsTeamMembers::class)->add(
                    $invitation->team->owner,
                    $invitation->team,
                    $invitation->email,
                    $invitation->role
                );

                $invitation->delete();
                return redirect(config('fortify.home'))->banner(
                    __('Great! You have accepted the invitation to join the :team team.', ['team' => $invitation->team->name]),
                );
            } else if(!Auth::user()->hasRole('Administrator')){
                return Response(view('no-team'));
            }
        }

        return $next($request);
    }
}
