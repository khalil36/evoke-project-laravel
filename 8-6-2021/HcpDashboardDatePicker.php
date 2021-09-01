<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB, Auth, User;
use App\Models\Team;
class HcpDashboardDatePicker extends Component
{
    public $reportingDates;
    public $dateRange;
    public $staringDate;

    public $start_date;
    public $end_date;

    public function render()
    {
        return view('livewire.hcp-dashboard-date-picker');
    }

    public function mount(){
        // todo: we should probably figure out what the defaul date range is and set it.
        //$this->>reportingDates = "2021-07-13 to 2021-07-15";
        $this->staringDate = Team::find(Auth::user()->current_team_id);

        $this->dateRange = array(
           'start' => array('2021-07-01', '2021-07-30', "2021-07-10", date('2021-07-20')),
            //'end' => (object)array("from" => '2021-07-01',"to" => '2021-07-30')
        );
        
        //iterate_triggers(array(0 => (object)array("triggerid" => 18186,"status" => 0,"value" => 1,)))
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
