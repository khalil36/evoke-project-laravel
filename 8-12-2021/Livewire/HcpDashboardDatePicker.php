<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB, Auth, User;
use App\Models\Team;
class HcpDashboardDatePicker extends Component
{
    public $reportingDates;
    public $dateRange;
    public $startingDate;

    public $start_date;
    public $end_date;

    public function render()
    {
        return view('livewire.hcp-dashboard-date-picker');
    }

    public function mount(){
        // todo: we should probably figure out what the defaul date range is and set it.
        //$this->>reportingDates = "2021-07-13 to 2021-07-15";
        $this->startingDate = Team::find(Auth::user()->current_team_id);
        
    }

    public function updatedReportingDates(){

        //check that user hasn't selected just one side of the date.
        //since livewire sends both events
        if(preg_match("/to/",$this->reportingDates)) {

            $dates = preg_split("/\sto\s/",$this->reportingDates);

            $this->emit('dateChanged',
                [
                    "start_date" => $dates[0],
                    "end_date" => $dates[1],
                ]
            );
        }
    }


}
