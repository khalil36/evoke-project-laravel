<?php

namespace App\Http\Livewire;

use App\Google\Services\Analytics\DfaReader;
use App\Jobs\processDFAFloodLightReporting;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HcpDashboardExportNpiActivity extends Component
{
    public $start_date;

    public $end_date;

    public $confirmingNpiExport = false;

    public $floodlights;

    public $activities=[];

    public $isDisabled = false;

    //we may need to change this to fire off a method that has a date parameter
    protected $listeners = ['dateChanged' => 'dateChanged'];

    public function dateChanged($dates){

        $this->start_date = $dates['start_date'];
        $this->end_date = $dates['end_date'];

    }

    public function mount(DfaReader $reader, Team $team){

        $this->floodlights = $reader->listFloodLightActivities($team);

        if (empty($this->end_date) && empty($this->start_date)) {

            $this->start_date = $team->flight_start_date;

            $flight_start_date_year_month = date('Y-m', strtotime($this->start_date));
            $current_year_month = date('Y-m');

            if ($flight_start_date_year_month == $current_year_month) {
                $this->end_date = date("Y-m-t");
            } elseif ($flight_start_date_year_month < $current_year_month) {
                $this->end_date = date('Y-m-d', strtotime('last day of previous month'));
            } else {
                $this->end_date = date('Y-m-t', strtotime($this->start_date));
            }
        }
    }

    public function updatedActivities($activites):void{
        $this->activities = $activites;
        if(count($activites) > 0 )
            $this->isDisabled = true;
        else
            $this->isDisabled = false;
    }

    public function render()
    {
        $this->mount(App::make(DfaReader::class), Auth::user()->currentTeam);

        return view('livewire.hcp-dashboard-export-npi-activity');
    }

    public function confirmNpiExport()
    {
        $this->resetErrorBag();

        $this->dispatchBrowserEvent('confirming-npi-export');

        $this->confirmingNpiExport = true;
    }

    public function export(Request $request)
    {

        $this->resetErrorBag();

        // Job call here.
        ProcessDFAFloodLightReporting::dispatch(Auth::user()->currentTeam, Auth::user()->id, $this->activities, $this->start_date, $this->end_date);

        session()->flash('success', 'NPI Export Activity Job has been queued.');

        return redirect()->to("/hcp");
    }

}

