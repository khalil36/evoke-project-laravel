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
        $this->team = Team::find(Auth::user()->current_team_id);

        if (!$this->end_date && !$this->start_date) {

            $this->start_date = $this->team->flight_start_date;

            $this->end_date = Helpers::getHcpInitialDates($this->start_date);
            // $flight_start_date_year_month = date('Y-m', strtotime($this->start_date));
            // $current_year_month = date('Y-m');

            // if ($flight_start_date_year_month == $current_year_month) {
            //     $this->end_date = date("Y-m-t");
            // } elseif ($flight_start_date_year_month < $current_year_month) {
            //     $this->end_date = date('Y-m-d', strtotime('last day of previous month'));
            // } else {
            //     $this->end_date = date('Y-m-t', strtotime($this->start_date));
            // }
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
