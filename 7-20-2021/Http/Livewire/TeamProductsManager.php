<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TeamProductsManager extends Component
{
    /**
     * The team instance.
     *
     * @var mixed
     */
    public $team;

    /**
     * The "add team member" form state.
     *
     * @var array
     */
    public $addTeamProductsForm = [
        'hcp' => null, //Health Care Provider Verification
        'pav' => null, //Patient Verification
    ];

    public $products = [1 => 'Patient Verification', 2 => 'Health Care Provider Verification'];

    public function mount(){
        $this->addTeamProductsForm['hcp'] = $this->team->has_hcp_access;
        $this->addTeamProductsForm['pav'] = $this->team->has_pav_access;
    }
    public function render()
    {
        return view('teams.team-products-manager');
    }

    /**
     * Add a new product to a team.
     *
     * @return void
     */
    public function addTeamProduct()
    {
        $this->team->has_hcp_access = $this->addTeamProductsForm['hcp'];
        $this->team->has_pav_access = $this->addTeamProductsForm['pav'];
        $this->team->update();
        $this->emit("refresh-navigation-menu");
    }
}
