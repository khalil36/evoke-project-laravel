<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Http\Livewire\CreateTeamForm;


class MyCreateTeamForm extends CreateTeamForm
{
    public $state = ['is_active' => 0];

    public function myCreateTeam(CreatesTeams $creator)
    {
        $this->resetErrorBag();
        $team = $creator->create(Auth::user(), $this->state);
        return redirect()->route('teams.show', ['team' => $team]);

    }

    public function render()
    {
        return view('livewire.my-create-team-form');
    }

}
