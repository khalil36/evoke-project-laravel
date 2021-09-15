<?php

namespace App\Http\Livewire;

use App\Google\Services\Analytics\DfaReader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HcpDashboardRawImpressionsClickBySite extends Component
{
    public $start_date = "2021-07-07";

    public $end_date = "2021-07-26";

    public $sites = [];

    public $readyToLoad = false;

    //we may need to change this to fire off a method that has a date parameter
    protected $listeners = ['dateChanged' => 'dateChanged'];

    public function loadSites(DfaReader $reader){
        $this->readyToLoad = true;
        $this->mount(App::make(DfaReader::class), Auth::user()->currentTeam);

    }

    public function dateChanged($dates, DfaReader $reader){
        $this->start_date = $dates['start_date'];
        $this->end_date = $dates['end_date'];
        $this->mount($reader, Auth::user()->currentTeam);

    }

    public function mount(DfaReader $reader, $team){
        if($this->readyToLoad)
            $this->sites = $reader->getRawImpressionsClicksBySite(Auth::user()->currentTeam, $this->start_date, $this->end_date);


    }
    public function render(DfaReader $reader)
    {
        return view('livewire.hcp-dashboard-raw-impressions-click-by-site',['sites' => $this->sites]);
        /*return view('livewire.hcp-dashboard-raw-impressions-click-by-site', [
            'sites' => $this->readyToLoad
                ? $reader->getRawImpressionsClicksBySite(Auth::user()->currentTeam, $this->start_date, $this->end_date)
                : [],
        ]);*/
    }
}
