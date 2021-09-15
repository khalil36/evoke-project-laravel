<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Http\Controllers\Livewire\TeamController;
use Laravel\Jetstream\Jetstream;

class ClientController extends TeamController
{
    /**
     * Show the client "teams" listing  screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        //$team = Jetstream::newTeamModel()->findOrFail($teamId);
/*
        if (Gate::denies('view', $team)) {
            abort(403);
        }
*/
        return view('teams.list', [
            'teams' => Team::orderBy('name')->get()
        ]);


    }
    public function create(Request $request){

        Gate::authorize('create', Jetstream::newTeamModel());

        return view('teams.create', [
            'user' => $request->user(),
        ]);
    }


}
