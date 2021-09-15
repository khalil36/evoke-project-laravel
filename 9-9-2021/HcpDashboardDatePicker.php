<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Team;
use App\Helpers\Helpers;
use DB, Auth, User;


class HcpDashboardDatePicker extends Component
{

    public $start_date;
    public $end_date;
    public $team;


    public function render()
    {
        return view('livewire.hcp-dashboard-date-picker');
    }

    public function mount()
    {   
        //use team in the datepicker blade file.
        $this->team = Team::find(Auth::user()->current_team_id);

        if (empty($this->end_date) && empty($this->start_date)) {

            $dates = Helpers::getHcpInitialDates(Auth::user()->current_team_id);
            $this->start_date = $dates['start_date'];
            $this->end_date = $dates['end_date'];
            
        }
    }

    public function updated()
    {

        if ($this->end_date && $this->start_date) {
            
            $this->emit('dateChanged',
                [
                    "start_date" => $this->start_date,
                    "end_date" => $this->end_date,
                ]
            );
        }
        
    }

}
